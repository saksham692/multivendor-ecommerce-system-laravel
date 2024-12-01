@extends('backend.admin.layouts.main')
@section('title', 'Products')
@section('breadcrumb')
    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
    <div class="breadcrumb-item"><a href="#">Product</a></div>
    <div class="breadcrumb-item">Products</div>
@endsection
@push('style')
    <!-- CSS Libraries -->
@endpush
@section('content')
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                @can('products.create')
                    <div class="text-right">
                        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Add new product</a>
                    </div>
                @endcan
            </div>
            <div class="col-12">
                <div class="card shadow border mt-3">
                    <div class="card-header border-bottom">
                        <h4 class="card-title">All Products</h4>
                    </div>
                    <div class="card-body">
                        {{--                        <div class="table-responsive">--}}
                        {{ $dataTable->table() }}
                        {{--                        </div>--}}
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
    <script>
        $(document).on('change', '.is_active', function () {
            let id = $(this).val();
            let is_checked = $(this).is(':checked') ? 1 : 0;
            $.ajax({
                url: '{{ route('admin.products.changeActiveStatus') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: id,
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
