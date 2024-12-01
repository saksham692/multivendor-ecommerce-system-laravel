@extends('backend.admin.layouts.main')
@section('title', 'Categories')
@section('breadcrumb')
    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
    <div class="breadcrumb-item"><a href="#">Product</a></div>
    <div class="breadcrumb-item">Categories</div>
@endsection
@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables/datatables.min.css') }}">
    <link rel="stylesheet"
          href="{{ asset('assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
@endpush
@section('content')
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                @can('categories.create')
                    <div class="text-right">
                        <a href="{{ route('admin.product.categories.create') }}" class="btn btn-primary">Add new category</a>
                    </div>
                @endcan
            </div>
            <div class="col-12">
                <div class="card shadow border mt-3">
                    <div class="card-header border-bottom">
                        <h4 class="card-title">All Categories</h4>
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
    <!-- JS Libraies -->
    <script src="{{ asset('assets/modules/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('assets/modules/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('assets/js/page/modules-datatables.js') }}"></script>
    <script>
        $(document).on('change', '.is_active', function () {
            let id = $(this).val();
            let is_checked = $(this).is(':checked') ? 1 : 0;
            $.ajax({
                url: '{{ route('admin.product.categories.changeActiveStatus') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    category_id: id,
                    is_active: is_checked,
                },
                success: function (response) {
                    if (response.status === 'success') {
                        toastr.success(response.message, "Success");
                    } else {
                        toastr.error(response.message, "Error");
                    }
                },
                error: function (error) {
                    toastr.error("An error occurred while updating the status.", "Error");
                }
            });
        });

    </script>

@endpush
