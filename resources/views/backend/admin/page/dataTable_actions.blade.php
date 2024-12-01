<div class="buttons">
    <a href="javascript:void(0);" data-href="{{ route('pages.show', $slug) }}"
       class="btn btn-icon btn-success url-copy-btn" data-toggle="tooltip" title="Copy Page Url"><i class="far fa-copy"></i></a>
    @can('pages.edit')
        <a href="{{ route('admin.pages.edit', encrypt($id)) }}"
           class="btn btn-icon btn-primary" data-toggle="tooltip" title="Edit Page"><i class="far fa-edit"></i></a>
    @endcan
    @can('pages.destroy')
        <a href="javascript:void(0);" class="btn btn-icon btn-danger delete-btn"
           data-href="{{ route('admin.pages.destroy', encrypt($id)) }}" data-toggle="tooltip" title="Delete Page"><i
                class="fas fa-trash"></i></a>
    @endcan
</div>
