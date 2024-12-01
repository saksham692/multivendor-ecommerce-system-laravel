@extends('backend.admin.layouts.main')
@section('title', 'New Product')
@section('breadcrumb')
    <div class="breadcrumb-item"><a href="#">Product</a></div>
    <div class="breadcrumb-item"><a href="#">Products</a></div>
    <div class="breadcrumb-item">Create</div>
@endsection
@push('page-specific-css')
    <link href="{{ asset('assets/modules/jquery-selectric/selectric.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/jquery-selectric/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
@endpush
@section('content')
    <div class="section-body">
        <div class="card shadow border mt-3">
            <div class="card-header border-bottom">
                <h4>New Product</h4>
            </div>
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-9 col-sm-12">
                            <!-- Name Field -->
                            <div class="row">
                                <div class="col-sm-12 col-md-6 form-group">
                                    <label>Is Featured?</label>
                                    <div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="is_featured_yes" name="is_featured"
                                                   class="custom-control-input"
                                                   value="1">
                                            <label class="custom-control-label" for="is_featured_yes">Yes</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="is_featured_no" name="is_featured"
                                                   class="custom-control-input"
                                                   value="0" checked>
                                            <label class="custom-control-label" for="is_featured_no">No</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 form-group">
                                    <label>Status</label>
                                    <div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="published" name="publish"
                                                   class="custom-control-input"
                                                   value="1" checked>
                                            <label class="custom-control-label" for="published">Published</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="draft" name="publish" class="custom-control-input"
                                                   value="0">
                                            <label class="custom-control-label" for="draft">Draft</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-12 form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" value="{{ old('name') }}"
                                           class="form-control @error('name') is-invalid @enderror">
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-sm-12 col-md-12 form-group">
                                    <label>Brand</label>
                                    <select class="form-control select2  @error('brand_id') is-invalid @enderror"
                                            name="brand_id">
                                        <option value="">Select Brand</option>
                                        @foreach(\App\Models\Brand::orderBy('name', 'asc')->get() as $brand)
                                            <option
                                                value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('brand_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Description Field -->
                                <div class="col-sm-12 col-md-12 form-group">
                                    <label>Description</label>
                                    <textarea id="description" name="description"
                                              class="form-control summernote">{{ old('description') }}</textarea>
                                    @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Thumbnail Image Upload Field -->
                                <div class="col-sm-12 col-md-6 form-group">
                                    <label>Images</label>
                                    <input type="file" name="images[]" id="images"
                                           class="form-control file-uploader @error('images') is-invalid @enderror"
                                           data-preview-container="imagesPreviewContainer" multiple/>
                                    @error('images')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    @error('images.*')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror                                <!-- Image Preview Container -->
                                    <div id="imagesPreviewContainer" class="image-preview-container"></div>
                                </div>

                                <div class="col-sm-12 col-md-6 form-group">
                                    <label>Thumbnail Image</label>
                                    <input type="file" name="thumbnail_img" id="thumbnail_img"
                                           class="form-control file-uploader @error('thumbnail_img') is-invalid @enderror"
                                           data-preview-container="thumbImagePreviewContainer">
                                    @error('thumbnail_img')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <!-- Image Preview Container -->
                                    <div id="thumbImagePreviewContainer" class="image-preview-container"></div>
                                </div>
                                <div class="col-sm-12 form-group">
                                    <label>Tags</label>
                                    <input class="form-control inputtags" name="tags"
                                           placeholder="Type & Enter" value="{{ old('tags') }}"/>
                                </div>
                            </div>

                            <!-- Price and stock -->
                            <div class="section-title mt-0">Price And Stock</div>
                            <div class="row">
                                <div class="col-sm-12 col-md-4 form-group">
                                    <label>SKU</label>
                                    <input type="text" class="form-control @error('sku') is-invalid @enderror"
                                           name="sku" value="{{ old('sku') }}">
                                    @error('sku')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-12 col-md-4 form-group">
                                    <label>Price</label>
                                    <input type="text" class="form-control @error('price') is-invalid @enderror"
                                           name="price" value="{{ old('price') }}">
                                    @error('price')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-12 col-md-4 form-group">
                                    <label>Discount Price</label>
                                    <input type="text"
                                           class="form-control @error('discount_price') is-invalid @enderror"
                                           name="discount_price" value="{{ old('discount_price') }}">
                                    @error('discount_price')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-12 col-md-6 form-group">
                                    <label>Total Stock</label>
                                    <input type="text" class="form-control @error('current_stock') is-invalid @enderror"
                                           name="current_stock" value="{{ old('current_stock') }}">
                                    @error('current_stock')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-12 col-md-6 form-group">
                                    <label>Barcode</label>
                                    <input type="text" class="form-control" name="barcode" value="{{ old('barcode') }}">
                                </div>
                                <div class="col-sm-12 col-md-12 form-group">
                                    <label class="d-block">Stock Status</label>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="in_stock" name="stock_status"
                                               class="custom-control-input" value="in_stock" checked>
                                        <label class="custom-control-label" for="in_stock">In Stock</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="out_of_stock" name="stock_status"
                                               class="custom-control-input"
                                               value="out_of_stock" {{ old('stock_status') == 'out_of_stock' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="out_of_stock">Out of Stock</label>
                                    </div>
                                    @error('stock_status')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="section-title mt-0">Wholesale Price</div>
                            <div class="row">
                                <div class="col-sm-12 form-group">
                                    <div id="wholesale-prices-reapeater">
                                        <div data-repeater-list="wholesale_prices">
                                            <div data-repeater-item>
                                                <div class="form-group row mb-0">
                                                    <div class=" col-md-3 col-sm-10 form-group">
                                                        <label>Minimum Quantity</label>
                                                        <input type="text" name="min_qty"
                                                               class="form-control" value="{{ old('min_qty') }}">
                                                    </div>
                                                    <div class="col-md-3 col-sm-10 form-group">
                                                        <label class="form-label">Maximum Quantity</label>
                                                        <input class="form-control" name="max_qty"
                                                               value="{{ old('max_qty') }}"/>
                                                    </div>
                                                    <div class="col-md-4 col-sm-10 form-group">
                                                        <label class="form-label">Price</label>
                                                        <input class="form-control" name="price"/>
                                                    </div>
                                                    <div class="col-md-2 form-group mt-auto">
                                                        <a href="javascript:;" data-repeater-delete
                                                           class="btn btn-danger">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            @error('wholesale_prices.*.min_qty')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                            @error('wholesale_prices.*.price')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <a href="javascript:;" data-repeater-create class="btn btn-primary mt-3">
                                            <i class="fa fa-plus"></i>
                                            Add
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- Taxes Repeater -->
                            {{--                            <div class="row">--}}
                            {{--                                <div class="col-sm-12 form-group">--}}
                            {{--                                    <div class="section-title mt-0">Taxes</div>--}}
                            {{--                                    <div id="taxes-reapeater">--}}
                            {{--                                        <div data-repeater-list="taxes">--}}
                            {{--                                            <div data-repeater-item>--}}
                            {{--                                                <div class="form-group row mb-0">--}}
                            {{--                                                    <div class=" col-md-5 col-sm-10 form-group">--}}
                            {{--                                                        <label>Name</label>--}}
                            {{--                                                        <input type="text" name="name"--}}
                            {{--                                                               class="form-control">--}}
                            {{--                                                    </div>--}}
                            {{--                                                    <div class="col-md-5 col-sm-10 form-group">--}}
                            {{--                                                        <label>Value</label>--}}
                            {{--                                                        <div class="input-group">--}}
                            {{--                                                            <div class="input-group-prepend">--}}
                            {{--                                                                <div class="input-group-text">--}}
                            {{--                                                                    %--}}
                            {{--                                                                </div>--}}
                            {{--                                                            </div>--}}
                            {{--                                                            <input type="text" name="value"--}}
                            {{--                                                                   class="form-control currency">--}}
                            {{--                                                        </div>--}}
                            {{--                                                    </div>--}}
                            {{--                                                    <div class="col-md-2 form-group mt-auto">--}}
                            {{--                                                        <a href="javascript:;" data-repeater-delete--}}
                            {{--                                                           class="btn btn-danger">--}}
                            {{--                                                            <i class="fa fa-trash"></i>--}}
                            {{--                                                        </a>--}}
                            {{--                                                    </div>--}}
                            {{--                                                </div>--}}
                            {{--                                            </div>--}}
                            {{--                                        </div>--}}
                            {{--                                        <a href="javascript:;" data-repeater-create class="btn btn-primary">--}}
                            {{--                                            <i class="fa fa-plus"></i>--}}
                            {{--                                            Add--}}
                            {{--                                        </a>--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                            <div class="section-title mt-0">Shipping</div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 form-group">
                                    <label>Weight (gm)</label>
                                    <input type="text" class="form-control @error('weight') is-invalid @enderror"
                                           name="weight" value="{{ old('weight') }}">
                                    @error('weight')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-12 col-md-6 form-group">
                                    <label>Length (cm)</label>
                                    <input type="text" class="form-control @error('length') is-invalid @enderror"
                                           name="length" value="{{ old('length') }}">
                                    @error('length')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-12 col-md-6 form-group">
                                    <label>Width (cm)</label>
                                    <input type="text" class="form-control @error('width') is-invalid @enderror"
                                           name="width" value="{{ old('width') }}">
                                    @error('width')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-12 col-md-6 form-group">
                                    <label>Height (cm)</label>
                                    <input type="text" class="form-control @error('height') is-invalid @enderror"
                                           name="height" value="{{ old('height') }}">
                                    @error('height')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!--
                            <div class="section-title mt-0">Attributes</div>
                            <div class="row">
                                <div class="col-sm-12 form-group">
                                    <div id="attributes-reapeater">
                                        <div data-repeater-list="attributes">
                                            <div data-repeater-item>
                                                <div class="form-group row mb-0">
                                                    <div class="col-sm-10 col-md-3 form-group">
                                                        <label>Attribute Name</label>
                                                        <select class="form-control select2 attribute_name"
                                                                name="attribute_name" data-kt-repeater="select2">
                                                            <option value="">Select</option>
                                                            @foreach($attributes as $attribute)
                                                                <option
                                                                    value="{{ $attribute->name }}" {{ old('attribute_name') == $attribute->id ? 'selected' : '' }}>
                                                                    {{ $attribute->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-10 col-md-7">
                                                        <div id="values-reapeater">
                                                            <div data-repeater-list="values">
                                                                <div data-repeater-item>
                                                                    <div class="form-group row mb-0">
                                                                        <div class=" col-md-3 col-sm-10 form-group">
                                                                            <label>Color</label>
                                                                            <input type="text" name="color"
                                                                                   value="{{ old('colors') }}"
                                                                                   class="form-control color-picker"
                                                                                   data-kt-repeater="color-picker">
                                                                        </div>
                                                                        <div class="col-md-5 col-sm-10 form-group">
                                                                            <label class="form-label">Name</label>
                                                                            <input class="form-control" name="title"/>
                                                                        </div>
                                                                        <div class="col-md-2 col-sm-10 form-group">
                                                                            <label class="form-label">Default</label>
                                                                            <div class="py-1">
                                                                                <label class="custom-switch">
                                                                                    <input type="checkbox"
                                                                                           name="default"
                                                                                           class="custom-switch-input set_default">
                                                                                    <span
                                                                                        class="custom-switch-indicator"></span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2 form-group mt-auto">
                                                                            <a href="javascript:;" data-repeater-delete
                                                                               class="btn btn-danger">
                                                                                <i class="fa fa-trash"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <a href="javascript:;" data-repeater-create
                                                               class="btn btn-primary mt-3">
                                                                <i class="fa fa-plus"></i>
                                                                Add
                                                            </a>
                                                        </div>
                                                    </div>
                                                    {{--                                                <div class="col-sm-10 col-md-5 form-group">--}}
                                                    {{--                                                    <label>Attribute Values</label>--}}
                                                    {{--                                                    <select class="form-control select2 attribute_values"--}}
                                                    {{--                                                            name="attribute_values" data-kt-repeater="select2" multiple>--}}
                                                    {{--                                                    </select>--}}
                                                    {{--                                                </div>--}}
                                                    <div class="col-md-2 form-group mt-auto">
                                                        <a href="javascript:;" data-repeater-delete
                                                           class="btn btn-danger">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="javascript:;" data-repeater-create class="btn btn-primary mt-3">
                                            <i class="fa fa-plus"></i>
                                            Add
                                        </a>
                                    </div>
                                </div>
                            </div>
                            -->
                            <div class="section-title mt-0">SEO</div>
                            <div class="row">
                                <div class="col-sm-12 form-group">
                                    <label>SEO Title</label>
                                    <input type="text" class="form-control @error('seo_title') is-invalid @enderror"
                                           name="seo_title" value="{{ old('seo_title') }}">
                                    @error('seo_title')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-12 form-group">
                                    <label>SEO Description</label>
                                    <textarea class="form-control @error('seo_description') is-invalid @enderror"
                                              name="seo_description" id="seo_description"
                                              maxlength="160">{{ old('seo_description') }}</textarea>
                                    <small id="seo_description_counter" class="form-text text-muted">160 characters
                                        remaining</small>
                                    @error('seo_description')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <div class="col-md-3 col-sm-12 pl-0 mt-3">
                            <div class="card shadow border">
                                <div class="card-header border-bottom">
                                    <h4>Categories</h4>
                                </div>
                                <div class="card-body ">
                                    <div class="" style="height: 300px; overflow: auto">
                                        @foreach ($categories as $category)
                                            @include('backend.admin.product.categoryTree', ['category' => $category])
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="card shadow border mt-3">
                                <div class="card-header border-bottom">
                                    <h4>Product Collections</h4>
                                </div>
                                <div class="card-body">
                                    @foreach($collections as $collection)
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="collections[]" class="custom-control-input"
                                                   id="{{ $collection->slug }}" value="{{ $collection->id }}">
                                            <label class="custom-control-label"
                                                   for="{{ $collection->slug }}">{{ $collection->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="card shadow border mt-3">
                                <div class="card-header border-bottom">
                                    <h4>Product Labels</h4>
                                </div>
                                <div class="card-body">
                                    @foreach($labels as $label)
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="labels[]" class="custom-control-input"
                                                   id="{{ $label->slug }}" value="{{ $label->id }}">
                                            <label class="custom-control-label"
                                                   for="{{ $label->slug }}">{{ $label->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <!-- Submit and Reset Buttons -->
                <div class="card-footer text-right">
                    <button class="btn btn-primary mr-1" type="submit">Submit</button>
                    <a class="btn btn-secondary" href="{{ route('admin.products.index') }}">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('custom-scripts')
    <script src="{{ asset('assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
    {{--    <script src="{{ asset('assets/modules/jquery-selectric/jquery.selectric.min.js') }}"></script>--}}
    <script src="{{ asset('plugins/repeater/repeater.js') }}"></script>
    <script src="{{ asset('assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>

    <script type="text/javascript">
        {{--$(document).on('change', '.attribute_name', function () {--}}
        {{--    let attribute_id = $(this).val(); // Use .val() to get the selected attribute ID--}}
        {{--    let values_select = $(this).parent().parent().find('.attribute_values');--}}

        {{--    $.ajax({--}}
        {{--        url: '{{ route('admin.products.getAttributeValues') }}',--}}
        {{--        method: 'POST',--}}
        {{--        data: {--}}
        {{--            _token: '{{ csrf_token() }}',--}}
        {{--            attribute_id: attribute_id,--}}
        {{--        },--}}
        {{--        success: function (response) {--}}
        {{--            if (response.status === 'success') {--}}
        {{--                values_select.html(''); // Clear existing options--}}
        {{--                response.attribute_values.forEach(function (value) {--}}
        {{--                    let option_value = value.name === null ? value.color : value.name;--}}
        {{--                    let option_text = value.name === null ? value.color : value.name;--}}

        {{--                    // Create a new option element--}}
        {{--                    let newOption = new Option(option_text, option_value, false, false);--}}
        {{--                    $(newOption).css('background-color', value.color); // Set background color for option display--}}
        {{--                    values_select.append(newOption); // Append the new option--}}
        {{--                });--}}

        {{--                // Initialize Select2 with custom template for displaying options--}}
        {{--                values_select.select2({--}}
        {{--                    templateResult: function (data) {--}}
        {{--                        if (!data.id) {--}}
        {{--                            return data.text; // Return default option if no ID--}}
        {{--                        }--}}
        {{--                        return $('<span class="p-1 text-white" style="background-color: ' + data.id + ';">' + data.text + '</span>'); // Custom styling--}}
        {{--                    },--}}
        {{--                    templateSelection: function (data) {--}}
        {{--                        return data.text; // Display selected text--}}
        {{--                    }--}}
        {{--                });--}}

        {{--                // Trigger change to refresh Select2 display--}}
        {{--                values_select.trigger('change');--}}

        {{--                toastr.success(response.message, "Success");--}}
        {{--            } else {--}}
        {{--                toastr.error('Something went wrong', "Error");--}}
        {{--            }--}}
        {{--        },--}}
        {{--        error: function (error) {--}}
        {{--            toastr.error("An error occurred while fetching attribute values.", "Error");--}}
        {{--        }--}}
        {{--    });--}}
        {{--});--}}
        $(document).on('keydown', 'input', function (e) {
            if (e.key === 'Enter') {
                // console.log('working')
                // Stop form submission, but keep the Enter key functionality
                let form = $(this).closest('form');
                if (form) {
                    form.on('submit', function (event) {
                        event.preventDefault(); // Prevent only the form submission
                    });
                }
                // console.log('Form submission prevented, Enter key still works.');
            }
        });
        $(document).ready(function () {
            // $('.select-picker').select2()

            // $('.color-picker').colorpicker();
            $(".inputtags").tagsinput()

            $('#seo_description').on('input', function () {
                var maxLength = 160;
                var currentLength = $(this).val().length;
                var remaining = maxLength - currentLength;

                $('#seo_description_counter').text(remaining + ' characters remaining');
            });

            $('#wholesale-prices-reapeater').repeater({
                initEmpty: false,

                show: function () {
                    // Slide down and make the element visible
                    $(this).slideDown();
                },

                hide: function (deleteElement) {
                    $(this).slideUp(deleteElement);
                },

                ready: function () {
                }
            });
            // $('#taxes-reapeater').repeater({
            //     initEmpty: false,
            //
            //     show: function () {
            //         // Slide down and make the element visible
            //         $(this).slideDown();
            //     },
            //
            //     hide: function (deleteElement) {
            //         $(this).slideUp(deleteElement);
            //     },
            //
            //     ready: function () {
            //     }
            // });
            $('#attributes-reapeater').repeater({
                repeaters: [{
                    selector: '#values-reapeater',
                    show: function () {
                        $(this).slideDown();
                        $('.set_default').each(function () {
                            // Uncheck all other checkboxes
                            if ($(this).get(0) !== $(event.target).get(0)) {
                                $(this).prop('checked', false);
                            }
                        });
                        // Re-init color picker or any other plugins
                        $(this).find('[data-kt-repeater="color-picker"]').colorpicker();
                    },

                    hide: function (deleteElement) {
                        $(this).slideUp(deleteElement);
                    },

                    ready: function () {
                        $(this).find('[data-kt-repeater="color-picker"]').colorpicker();
                    }
                }],

                initEmpty: false,

                show: function () {
                    // Slide down and make the element visible
                    $(this).slideDown();
                    $(this).find('[data-kt-repeater="color-picker"]').colorpicker();
                    $(this).find('.select2-hidden-accessible').removeClass('select2-hidden-accessible');
                    $(this).find('.select2-container').remove();
                    // Reinitialize Select2
                    $(this).find('.select2').select2();
                },

                hide: function (deleteElement) {
                    $(this).slideUp(deleteElement);
                },

                ready: function () {
                    // $('[data-kt-repeater="select2"]').select2();
                    $(this).find('[data-kt-repeater="color-picker"]').colorpicker();

                }
            });

        });
    </script>
@endpush
