@extends('backend.admin.layouts.main')
@section('title', 'New Page')
@section('breadcrumb')
    <div class="breadcrumb-item"><a href="#">Pages</a></div>
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
                        <h4>New Page</h4>
                    </div>
                    <form action="{{ route('admin.pages.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <!-- Name Field -->
                            <div class="row">
                                <div class="col-sm-12 form-group">
                                    <label>Page Title</label>
                                    <input type="text" name="title" value="{{ old('title') }}"
                                           class="form-control @error('title') is-invalid @enderror">
                                    @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-sm-12 form-group">
                                    <label>Content</label>
                                    <textarea name="content" class="form-control summernote" cols="30" rows="10"></textarea>
                                    @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Submit and Reset Buttons -->
                        <div class="card-footer text-right">
                            <button class="btn btn-primary mr-1" type="submit">Submit</button>
                            <a class="btn btn-secondary" href="{{ route('admin.pages.index') }}">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('custom-scripts')
    <script>
    </script>
@endpush
