<div class="buttons">
    @can('products.edit')
        <a href="{{ route('admin.products.edit', encrypt($id)) }}"
           class="btn btn-icon btn-primary"><i class="far fa-edit"></i></a>
    @endcan
    @can('products.destroy')
        <a href="javascript:void(0);" class="btn btn-icon btn-danger delete-btn"
           data-href="{{ route('admin.products.destroy', encrypt($id)) }}"><i
                class="fas fa-trash"></i></a>
    @endcan
</div>
