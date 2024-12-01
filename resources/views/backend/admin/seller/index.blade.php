@extends('backend.admin.layouts.main')
@section('title', 'Sellers')
@section('breadcrumb')
    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
    <div class="breadcrumb-item">Sellers</div>
@endsection
@push('style')
@endpush
@section('content')
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                @can('sellers.create')
                    <div class="text-right">
                        <a href="{{ route('admin.sellers.create') }}" class="btn btn-primary">Add new seller</a>
                    </div>
                @endcan
            </div>
            <div class="col-12">
                <div class="card shadow border mt-3">
                    <div class="card-header border-bottom">
                        <h4 class="card-title">All Sellers</h4>
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
