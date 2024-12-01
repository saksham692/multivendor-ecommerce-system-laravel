<div class="buttons">
    <a href="{{ route('admin.roles.edit', encrypt($id)) }}"
       class="btn btn-icon btn-primary" data-toggle="tooltip" title="Edit Role"><i class="far fa-edit"></i></a>
    <a href="{{ route('admin.roles.permissions.assign', encrypt($id)) }}"
       class="btn btn-icon btn-warning" data-toggle="tooltip" title="Assign Permissions"><i class="fas fa-sitemap"></i></a>
    <a href="javascript:void(0);" class="btn btn-icon btn-danger delete-btn"
       data-href="{{ route('admin.roles.destroy', encrypt($id)) }}" data-toggle="tooltip" title="Delete Role"><i
            class="fas fa-trash"></i></a>
</div>
