@extends('backend.admin.layouts.main')
@section('title', 'Edit Page')
@section('breadcrumb')
    <div class="breadcrumb-item"><a href="#">Pages</a></div>
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
                        <h4>Edit Page</h4>
                    </div>
                    <form action="{{ route('admin.pages.update', $page->id) }}" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 form-group">
                                    <label>Page Title</label>
                                    <input type="text" name="title" value="{{ $page->title }}"
                                           class="form-control @error('title') is-invalid @enderror">
                                    @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-sm-12 form-group">
                                    <label>Content</label>
                                    <textarea name="content" class="form-control summernote" cols="30" rows="10">{{ $page->content }}</textarea>
                                    @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- Submit and Reset Buttons -->
                        <div class="card-footer text-right">
                            <button class="btn btn-primary mr-1" type="submit">Update</button>
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
        $('#cp1').colorpicker({
            inline: true,
            container: true,
            extensions: [
                {
                    name: 'swatches', // extension name to load
                    options: { // extension options
                        colors: {
                            '#6777ef': '#6777ef',
                            '#cdd3d8': '#cdd3d8',
                            '#ffffff': '#ffffff',
                            '#fc544b': '#fc544b',
                            '#ffa426': '#ffa426',
                            '#3abaf4': '#3abaf4',
                            '#63ed7a': '#63ed7a',
                        },
                        namesAsValues: true
                    }
                }
            ]
        });
    </script>
@endpush
