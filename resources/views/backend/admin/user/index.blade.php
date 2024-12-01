@extends('backend.admin.layouts.main')
@section('title', 'Users')
@section('breadcrumb')
    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
    <div class="breadcrumb-item">Users</div>
@endsection
@push('style')
@endpush
@section('content')
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                @can('users.create')
                    <div class="text-right">
                        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Add new user</a>
                    </div>
                @endcan
            </div>
            <div class="col-12">
                <div class="card shadow border mt-3">
                    <div class="card-header border-bottom">
                        <h4 class="card-title">All Users</h4>
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
@endpush
