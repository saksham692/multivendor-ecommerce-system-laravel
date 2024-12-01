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
                <div class="text-right">
                    <a href="{{ route('admin.product.categories.create') }}" class="btn btn-primary">Add new category</a>
                </div>
            </div>
            <div class="col-12">
                <div class="card shadow border mt-3">
                    <div class="card-header border-bottom">
                        <h4 class="card-title">All Categories</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Parent</th>
                                <th scope="col">Icon</th>
                                <th scope="col">Status</th>
                                <th scope="col">Options</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $key => $category)
                                <tr>
                                    <th scope="row">{{ $key + 1 }}</th>
{{--                                    <th scope="row">{{ ($key+1) + ($categories->currentPage() - 1)*$categories->perPage() }}</th>--}}
                                    <td>{{ $category->name }}</td>
                                    <td>{{ optional($category->parent)->name }}</td>
                                    <td><i class="fa {{ $category->icon }}"></i></td>
                                    <td>{!! $category->publish == 0 ? '<span class="badge badge-danger">Un Published</span>' :  '<span class="badge badge-success">Published</span>' !!}</td>
                                    <td>
                                        <div class="buttons">
                                            <a href="{{ route('admin.product.categories.edit', encrypt($category->id)) }}"
                                               class="btn btn-icon btn-primary"><i class="far fa-edit"></i></a>
                                            <a href="javascript:void(0);" class="btn btn-icon btn-danger delete-btn"
                                            data-href="{{ route('admin.product.categories.destroy', encrypt($category->id)) }}"><i
                                                    class="fas fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
{{--                        {{ $categories->links('backend.pagination') }}--}}
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

@endpush
