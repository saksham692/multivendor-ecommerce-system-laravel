<div class="buttons">
    @can('users.edit')
        <a href="{{ route('admin.users.edit', encrypt($id)) }}"
           class="btn btn-icon btn-primary" data-toggle="tooltip" title="Edit User"><i class="far fa-edit"></i></a>
    @endcan
    @can('users.destroy')
        <a href="javascript:void(0);" class="btn btn-icon btn-danger delete-btn"
           data-href="{{ route('admin.users.destroy', encrypt($id)) }}" data-toggle="tooltip" title="Delete User"><i
                class="fas fa-trash"></i></a>
    @endcan
</div>
