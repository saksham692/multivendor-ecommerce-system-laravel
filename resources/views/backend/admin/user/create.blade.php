@extends('backend.admin.layouts.main')
@section('title', 'New User')
@section('breadcrumb')
    <div class="breadcrumb-item"><a href="#">Users</a></div>
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
                        <h4>New User</h4>
                    </div>
                    <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <!-- Name Field -->
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control @error('name') 'is-invalid' @enderror" name="name" value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control @error('email') 'is-invalid' @enderror" name="email" value="{{ old('email') }}">
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" class="form-control @error('password') 'is-invalid' @enderror" name="password" value="{{ old('password') }}">
                                        @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Confirm password</label>
                                        <input type="password" class="form-control @error('password_confirmation') 'is-invalid' @enderror" name="password_confirmation" value="{{ old('password_confirmation') }}">
                                        @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputState">Role</label>
                                <select id="inputState" class="form-control @error('role') 'is-invalid' @enderror" name="role">
                                    <option value="">Select</option>
                                    @foreach(\Spatie\Permission\Models\Role::all() as $role)
                                    <option value="{{ $role->name }}"  {{ old('role') && old('role') == $role->name ? 'selected' : '' }}>{{ ucfirst($role->name) }}</option>
                                    @endforeach
                                </select>
                                @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit and Reset Buttons -->
                        <div class="card-footer text-right">
                            <button class="btn btn-primary mr-1" type="submit">Submit</button>
                            <a class="btn btn-secondary" href="{{ route('users.index') }}">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('custom-scripts')
@endpush
