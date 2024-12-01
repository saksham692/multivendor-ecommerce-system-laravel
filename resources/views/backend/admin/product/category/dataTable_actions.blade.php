<div class="buttons">
    @can('categories.manage')
        <a href="{{ route('admin.product.categories.edit', encrypt($id)) }}"
           class="btn btn-icon btn-primary"><i class="far fa-edit"></i></a>
    @endcan
    @can('categories.destroy')
        <a href="javascript:void(0);" class="btn btn-icon btn-danger delete-btn"
           data-href="{{ route('admin.product.categories.destroy', encrypt($id)) }}"><i
                class="fas fa-trash"></i></a>
    @endcan
</div>
