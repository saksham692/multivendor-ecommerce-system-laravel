@extends('backend.admin.layouts.main')
@section('title', 'New Role')
@section('breadcrumb')
    <div class="breadcrumb-item"><a href="#">Product</a></div>
    <div class="breadcrumb-item"><a href="#">Roles</a></div>
    <div class="breadcrumb-item">Create</div>
@endsection
@push('style')
@endpush
@section('content')
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card shadow border mt-3">
                    <div class="card-header border-bottom">
                        <h4>New Role</h4>
                    </div>
                    <form action="{{ route('admin.roles.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <!-- Name Field -->
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror">
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit and Reset Buttons -->
                        <div class="card-footer text-right">
                            <button class="btn btn-primary mr-1" type="submit">Submit</button>
                            <a class="btn btn-secondary" href="{{ route('admin.roles.index') }}">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('custom-scripts')
@endpush
