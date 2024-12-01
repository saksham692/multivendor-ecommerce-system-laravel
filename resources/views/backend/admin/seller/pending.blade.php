@extends('backend.admin.layouts.main')
@section('title', 'Pending Sellers')
@section('breadcrumb')
    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
    <div class="breadcrumb-item">Pending Sellers</div>
@endsection
@push('style')
@endpush
@section('content')
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card shadow border mt-3">
                    <div class="card-header border-bottom">
                        <h4 class="card-title">Sellers Pending Applications</h4>
                    </div>
                    <div class="card-body">
                        {{ $dataTable->table() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <!-- Button trigger modal -->
    <!-- Modal -->
    @include('backend.admin.modal.delete')
@endsection
@push('custom-scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

    <script type="text/javascript">
        $(document).on('click', '.approve-seller', function () {
            var seller_id = $(this).data('id');
            $.ajax({
                method: 'POST',
                url: '{{ route('sellers.approve') }}',
                dataType: 'json',
                data: {
                    _token: '{{ csrf_token() }}',
                    seller_id: seller_id
                },
                success: function (response) {
                    if (response.status == 'success') {
                        var table = $('#seller-table').DataTable();
                        table.ajax.reload(null, false); // Reloads without resetting pagination
                        toastr.success(response.message);
                    } else {
                        toastr.error('Something went wrong');
                    }
                },
                error: function () {
                    toastr.error('Something went wrong');
                }
            });
        });

        $(document).on('click', '.reject-seller', function () {
            var seller_id = $(this).data('id');
           $.ajax({
               method: 'POST',
               url: '{{ route('sellers.reject') }}',
               dataType: 'json',
               data:{
                   _token: '{{ csrf_token() }}',
                   seller_id: seller_id
               },
               success: function (response) {
                   if (response.status == 'success'){
                       var table = $('#seller-table').DataTable();
                       table.ajax.reload(null, false); // Reloads without resetting pagination
                       toastr.success(response.message)
                   }else {
                       toastr.error('Something went wrong')
                   }
               },
               error: function () {
                   toastr.error('Something went wrong')
               }
           });
        });
    </script>
@endpush
