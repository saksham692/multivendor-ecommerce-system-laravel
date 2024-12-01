@extends('backend.admin.layouts.main')
@section('title', 'Assign Permissions')
@section('breadcrumb')
    <div class="breadcrumb-item"><a href="#">Product</a></div>
    <div class="breadcrumb-item"><a href="#">Roles</a></div>
    <div class="breadcrumb-item">Assign Permissions</div>
@endsection
@push('style')
@endpush
@section('content')
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card shadow border mt-3">
                    <div class="card-header border-bottom">
                        <h4>Assign Permissions</h4>
                    </div>
                    <form action="{{ route('admin.roles.permissions.update', $role) }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <!-- Name Field -->
                            <div class="form-group">
                               <h3 class="fw-bold fs-6">Role: {{ ucfirst($role->name) }}</h3>
                            </div>
                            <div class="form-group">
                                <h4 class="text-muted">Select Permissions</h4>
                                <div class="row">
                                    @foreach($permissions as $permission)

                                        <div class="col-md-3">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="permissions[]" class="custom-control-input"
                                                       id="{{ $permission->name.'_'.$permission->id }}"
                                                       value="{{ $permission->id }}" {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                                                <label class="custom-control-label"
                                                       for="{{ $permission->name.'_'.$permission->id }}">{{ $permission->name }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>

                        <!-- Submit and Reset Buttons -->
                        <div class="card-footer text-right">
                            <button class="btn btn-primary mr-1" type="submit">Update</button>
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
