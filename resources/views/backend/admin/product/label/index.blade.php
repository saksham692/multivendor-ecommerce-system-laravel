@extends('backend.admin.layouts.main')
@section('title', 'Labels')
@section('breadcrumb')
    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
    <div class="breadcrumb-item"><a href="#">Product</a></div>
    <div class="breadcrumb-item">Labels</div>
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
                @can('labels.create')
                    <div class="text-right">
                        <a href="{{ route('admin.product.labels.create') }}" class="btn btn-primary">Add new label</a>
                    </div>
                @endcan
            </div>
            <div class="col-12">
                <div class="card shadow border mt-3">
                    <div class="card-header border-bottom">
                        <h4 class="card-title">All Labels</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Color</th>
                                    <th scope="col">Featured</th>
                                    <th scope="col">Active</th>
                                    <th scope="col">Options</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($labels as $key => $label)
                                    <tr>
                                        <th scope="row">{{ $key + 1 }}</th>
                                        {{--                                        <th scope="row">{{ ($key+1) + ($labels->currentPage() - 1)*$labels->perPage() }}</th>--}}
                                        <td>{{ $label->name }}</td>
                                        <td><span class="badge text-white"
                                                  style="background: {{ $label->color }};">{{ $label->name }}</span>
                                        </td>
                                        <td>
                                            <label class="custom-switch">
                                                <input type="checkbox" name="is_featured" value="{{ $label->id }}"
                                                       class="custom-switch-input is_featured" {{ $label->is_featured == 1 ? 'checked' : '' }}>
                                                <span class="custom-switch-indicator"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="custom-switch ">
                                                <input type="checkbox" name="is_active" value="{{ $label->id }}"
                                                       class="custom-switch-input is_active" {{ $label->is_active == 1 ? 'checked' : '' }}>
                                                <span class="custom-switch-indicator"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <div class="buttons">
                                                @can('labels.edit')
                                                    <a href="{{ route('admin.product.labels.edit', encrypt($label->id)) }}"
                                                       class="btn btn-icon btn-primary"><i class="far fa-edit"></i></a>
                                                @endcan
                                                @can('labels.destroy')
                                                    <a href="javascript:void(0);"
                                                       class="btn btn-icon btn-danger delete-btn"
                                                       data-href="{{ route('admin.product.labels.destroy', encrypt($label->id)) }}"><i
                                                            class="fas fa-trash"></i></a>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{--                        {{ $labels->links('backend.pagination') }}--}}
                        </div>
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
    <!-- JS Libraies -->
    <script src="{{ asset('assets/modules/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('assets/modules/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('assets/js/page/modules-datatables.js') }}"></script>
    <script>
        $(document).on('change', '.is_featured', function () {
            let id = $(this).val();
            let is_checked = $(this).is(':checked') ? 1 : 0; // Convert boolean to 1 or 0

            $.ajax({
                url: '{{ route('admin.product.labels.changeFeaturedStatus') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    label_id: id, // Matching key with the controller method
                    is_featured: is_checked, // Matching key with the controller method
                },
                success: function (response) {
                    if (response.is_featured) { // Optional: check response content
                        toastr.success(response.message, "Success");
                    } else {
                        toastr.error(response.message, "Error");
                    }
                },
                error: function (xhr, status, error) {
                    toastr.error('An error occurred while updating the featured status.', "Error");
                }
            });
        });
        $(document).on('change', '.is_active', function () {
            let id = $(this).val();
            let is_checked = $(this).is(':checked') ? 1 : 0;
            $.ajax({
                url: '{{ route('admin.product.labels.changeActiveStatus') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    label_id: id,
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
