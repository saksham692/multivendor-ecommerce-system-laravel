$.fn.repeaterVal = function () {
    var parse = function (raw) {
        var parsed = [];

        $.each(raw, function (key, val) {
            if (key !== "undefined") {
                var parsedKey = [];
                parsedKey.push(key.match(/^[^\[]*/)[0]);
                parsedKey = parsedKey.concat($.map(
                    key.match(/\[[^\]]*\]/g),
                    function (bracketed) {
                        return bracketed.replace(/[\[\]]/g, '');
                    }
                ));

                parsed.push({
                    val: val,
                    key: parsedKey
                });
            }
        });

        return parsed;
    };

    var build = function (parsed) {
        if (parsed.length === 1 &&
            (parsed[0].key.length === 0 || (parsed[0].key.length === 1 && !parsed[0].key[0]))) {
            return parsed[0].val;
        }

        $.each(parsed, function (index, p) {
            p.head = p.key.shift();
        });

        var grouped = {};
        $.each(parsed, function (index, p) {
            if (!grouped[p.head]) {
                grouped[p.head] = [];
            }
            grouped[p.head].push(p);
        });

        var built;
        if (/^[0-9]+$/.test(parsed[0].head)) {
            built = [];
            $.each(grouped, function (index, group) {
                built.push(build(group));
            });
        } else {
            built = {};
            $.each(grouped, function (key, group) {
                built[key] = build(group);
            });
        }

        return built;
    };

    return build(parse($(this).inputVal()));
};

$.fn.repeater = function (fig) {
    fig = fig || {};

    var setList;

    $(this).each(function () {
        var $self = $(this);

        var show = fig.show || function () {
            $(this).show();
        };

        var hide = fig.hide || function (removeElement) {
            removeElement();
        };

        var $list = $self.find('[data-repeater-list]').first();

        var $filterNested = function ($items, repeaters) {
            return $items.filter(function () {
                return repeaters ?
                    $(this).closest(
                        $.map(repeaters, function (repeater) {
                            return repeater.selector;
                        }).join(',')
                    ).length === 0 : true;
            });
        };

        var $items = function () {
            return $filterNested($list.find('[data-repeater-item]'), fig.repeaters);
        };

        var $itemTemplate = $list.find('[data-repeater-item]')
            .first().clone().hide();

        var $firstDeleteButton = $filterNested(
            $filterNested($(this).find('[data-repeater-item]'), fig.repeaters)
                .first().find('[data-repeater-delete]'),
            fig.repeaters
        );

        if (fig.isFirstItemUndeletable && $firstDeleteButton) {
            $firstDeleteButton.remove();
        }

        var getGroupName = function () {
            var groupName = $list.data('repeater-list');
            return fig.$parent ?
                fig.$parent.data('item-name') + '[' + groupName + ']' :
                groupName;
        };

        var initNested = function ($listItems) {
            if (fig.repeaters) {
                $listItems.each(function () {
                    var $item = $(this);

                    $.each(fig.repeaters, function (index, nestedFig) {
                        $item.find(nestedFig.selector).repeater($.extend(
                            {}, nestedFig, { $parent: $item }
                        ));
                    });
                });
            }
        };

        var setIndexes = function ($items, groupName, repeaters) {
            $items.each(function (index) {
                var $item = $(this);
                $item.data('item-name', groupName + '[' + index + ']');
                $filterNested($item.find('[name]'), repeaters).each(function () {
                    var $input = $(this);
                    var matches = $input.attr('name').match(/\[[^\]]+\]/g);
                    var name = matches ?
                        matches[matches.length - 1].replace(/\[|\]/g, '') :
                        $input.attr('name');
                    var newName = groupName + '[' + index + '][' + name + ']' +
                        ($input.is(':checkbox') || $input.attr('multiple') ? '' : '');
                    $input.attr('name', newName);

                    if (repeaters) {
                        $.each(repeaters, function (index, nestedFig) {
                            var $repeater = $item.find(nestedFig.selector);
                            setIndexes(
                                $filterNested($repeater.find('[data-repeater-item]'), nestedFig.repeaters || []),
                                groupName + '[' + index + '][' + $repeater.find('[data-repeater-list]').first().data('repeater-list') + ']',
                                nestedFig.repeaters
                            );
                        });
                    }
                });
            });

            $list.find('input[name][checked]')
                .removeAttr('checked')
                .prop('checked', true);
        };

        setIndexes($items(), getGroupName(), fig.repeaters);
        initNested($items());
        if (fig.initEmpty) {
            $items().remove();
        }

        if (fig.ready) {
            fig.ready(function () {
                setIndexes($items(), getGroupName(), fig.repeaters);
            });
        }

        var appendItem = function ($item, data) {
            var setItemsValues = function ($item, data, repeaters) {
                if (data || fig.defaultValues) {
                    var inputNames = {};
                    $filterNested($item.find('[name]'), repeaters).each(function () {
                        var key = $(this).attr('name').match(/\[([^\]]*)(\]|\]\[\])$/)[1];
                        inputNames[key] = $(this).attr('name');
                    });

                    $item.inputVal($.map(data || fig.defaultValues, function (val, name) {
                        return inputNames[name] ? inputNames[name] : null;
                    }));
                }

                if (repeaters) {
                    $.each(repeaters, function (index, nestedFig) {
                        var $repeater = $item.find(nestedFig.selector);
                        $filterNested($repeater.find('[data-repeater-item]'), nestedFig.repeaters)
                            .each(function () {
                                var fieldName = $repeater.find('[data-repeater-list]').data('repeater-list');
                                if (data && data[fieldName]) {
                                    var $template = $(this).clone();
                                    $repeater.find('[data-repeater-item]').remove();
                                    $.each(data[fieldName], function (index, data) {
                                        var $item = $template.clone();
                                        setItemsValues($item, data, nestedFig.repeaters || []);
                                        $repeater.find('[data-repeater-list]').append($item);
                                    });
                                } else {
                                    setItemsValues($(this), nestedFig.defaultValues, nestedFig.repeaters || []);
                                }
                            });
                    });
                }
            };

            $list.append($item);
            setIndexes($items(), getGroupName(), fig.repeaters);
            $item.find('[name]').each(function () {
                $(this).val('');
            });
            setItemsValues($item, data || fig.defaultValues, fig.repeaters);
        };

        var addItem = function (data) {
            var $item = $itemTemplate.clone();
            appendItem($item, data);
            if (fig.repeaters) {
                initNested($item);
            }
            show.call($item.get(0));
        };

        setList = function (rows) {
            $items().remove();
            $.each(rows, function (index, data) {
                addItem(data);
            });
        };

        $filterNested($self.find('[data-repeater-create]'), fig.repeaters).click(function () {
            addItem();
        });

        $list.on('click', '[data-repeater-delete]', function () {
            var self = $(this).closest('[data-repeater-item]').get(0);
            hide.call(self, function () {
                $(self).remove();
                setIndexes($items(), getGroupName(), fig.repeaters);
            });
        });
    });

    this.setList = setList;

    return this;
};
