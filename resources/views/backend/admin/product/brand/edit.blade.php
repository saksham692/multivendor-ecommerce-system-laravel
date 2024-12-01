@extends('backend.admin.layouts.main')
@section('title', 'Edit Brand')
@section('breadcrumb')
    <div class="breadcrumb-item"><a href="#">Product</a></div>
    <div class="breadcrumb-item"><a href="#">Brands</a></div>
    <div class="breadcrumb-item">Edit</div>
@endsection
@push('style')
@endpush
@section('content')
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card shadow border mt-3">
                    <div class="card-header border-bottom">
                        <h4>Edit Brand</h4>
                    </div>
                    <form action="{{ route('admin.product.brands.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <!-- Name Field -->
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" value="{{ $brand->name }}"
                                       class="form-control @error('name') is-invalid @enderror">
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <div class="form-group">
                                    <label>Logo</label>
                                    <input type="file" name="logo" id="logo"
                                           class="form-control file-uploader @error('logo') is-invalid @enderror"
                                           data-preview-container="imagePreviewContainer">
                                    @error('logo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- Image Preview Container -->
                                <div id="imagePreviewContainer" class="image-preview-container"></div>
                            </div>

                            <div class="form-group">
                                <label>Is Featured?</label>
                                <div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="is_featured_yes" name="is_featured"
                                               class="custom-control-input"
                                               value="1" {{ $brand->is_featured == 1 ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_featured_yes">Yes</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="is_featured_no" name="is_featured"
                                               class="custom-control-input"
                                               value="0" {{ $brand->is_featured == 0 ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_featured_no">No</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Is Active?</label>
                                <div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="is_active_yes" name="is_active"
                                               class="custom-control-input"
                                               value="1"  {{ $brand->is_active == 1 ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_active_yes">Yes</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="is_active_no" name="is_active"
                                               class="custom-control-input"
                                               value="0"  {{ $brand->is_active == 0 ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_active_no">No</label>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Submit and Reset Buttons -->
                        <div class="card-footer text-right">
                            <button class="btn btn-primary mr-1" type="submit">Update</button>
                            <a class="btn btn-secondary" href="{{ route('admin.product.brands.index') }}">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('custom-scripts')
@endpush
