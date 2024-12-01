@extends('backend.admin.layouts.main')
@section('title', 'Edit Category')
@section('breadcrumb')
    <div class="breadcrumb-item"><a href="#">Product</a></div>
    <div class="breadcrumb-item"><a href="#">Categories</a></div>
    <div class="breadcrumb-item">Edit</div>
@endsection
@push('style')
    <link href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/modules/jquery-selectric/selectric.css') }}" rel="stylesheet">

@endpush
@section('content')
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card shadow border mt-3">
                    <div class="card-header border-bottom">
                        <h4>Edit Category</h4>
                    </div>
                    <form action="{{ route('admin.product.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <!-- Name Field -->
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" value="{{ $category->name }}"
                                       class="form-control @error('name') is-invalid @enderror">
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Parent Category Field -->
                            <div class="form-group">
                                <label>Parent</label>
                                <select class="form-control select2" name="parent_id">
                                    <option value="">Select Parent Category</option>
                                    @foreach(\App\Models\Category::whereNot('id', $category->id)->orderBy('name', 'asc')->get() as $categoryy)
                                        <option
                                            value="{{ $categoryy->id }}" {{ $category->parent_id == $categoryy->id ? 'selected' : '' }}>{{ $categoryy->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Icon Field -->
                            <div class="form-group">
                                <label>Icon</label>
                                <div>
                                    <button class="btn btn-primary" data-icon="{{$category->icon}}" data-selected-class="btn-danger"
                                            data-unselected-class="btn-info" role="iconpicker" name="icon" ></button>
                                </div>
                                @error('icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description Field -->
                            <div class="form-group">
                                <label>Description</label>
                                <textarea id="description" name="description"
                                          class="form-control">{{ $category->description }}</textarea>
                            </div>

                            <!-- Thumbnail Image Upload Field -->
                            <div class="form-group">
                                <label>Thumbnail Image</label>
                                <input type="file" name="thumbnail_img" id="thumbnail_img"
                                       class="form-control file-uploader @error('thumbnail_img') is-invalid @enderror"
                                       data-preview-container="imagePreviewContainer">
                                <input type="hidden" value="{{ $category->thumbnail_img }}" name="thumbnail">
                                @error('thumbnail_img')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Image Preview Container -->
                            <div id="imagePreviewContainer" class="image-preview-container">
                                @if($category->thumbnail_img != '' && $category->thumbnail_img != null && is_numeric($category->thumbnail_img))
                                    <div class="image-preview" data-file-index="{{ $category->thumbnail_img }}">
                                        <img src="{{ getUpload($category->thumbnail_img) }}" alt="Image Preview">
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Submit and Reset Buttons -->
                        <div class="card-footer text-right">
                            <button class="btn btn-primary mr-1" type="submit">Update</button>
                            <a class="btn btn-secondary" href="{{ route('admin.product.categories.index') }}">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('custom-scripts')
    <script src="{{ asset('assets/modules/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('assets/modules/jquery-selectric/jquery.selectric.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#description').summernote({
                tabsize: 2,
                height: 200
            });
        });
    </script>
@endpush
