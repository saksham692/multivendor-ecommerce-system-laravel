<div class="buttons">
    <a href="{{ route('admin.permissions.edit', encrypt($id)) }}"
       class="btn btn-icon btn-primary"><i class="far fa-edit"></i></a>
    <a href="javascript:void(0);" class="btn btn-icon btn-danger delete-btn"
       data-href="{{ route('admin.permissions.destroy', encrypt($id)) }}"><i
            class="fas fa-trash"></i></a>
</div>
