<div class="buttons">
    @if(Route::currentRouteName() == 'sellers.pending')
        <a href="javascript:void(0);"
           class="btn btn-icon btn-success approve-seller" data-toggle="tooltip" title="Approve Seller" data-id="{{ $id }}"><i class="fa fa-check"></i></a>
        <a href="javascript:void(0);"
           class="btn btn-icon btn-warning reject-seller" data-toggle="tooltip" title="Reject Seller" data-id="{{ $id }}"><i class="fa fa-times"></i></a>
    @endif
    @can('sellers.edit')
        <a href="{{ route('sellers.edit', encrypt($id)) }}"
           class="btn btn-icon btn-primary" data-toggle="tooltip" title="Edit Seller"><i class="far fa-edit"></i></a>
    @endcan
    @can('sellers.destroy')
        <a href="javascript:void(0);" class="btn btn-icon btn-danger delete-btn"
           data-href="{{ route('sellers.destroy', encrypt($id)) }}" data-toggle="tooltip" title="Delete Seller"><i
                class="fas fa-trash"></i></a>
    @endcan
</div>
