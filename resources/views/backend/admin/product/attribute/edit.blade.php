@extends('backend.admin.layouts.main')
@section('title', 'Edit Attribute')
@section('breadcrumb')
    <div class="breadcrumb-item"><a href="#">Product</a></div>
    <div class="breadcrumb-item"><a href="#">Attributes</a></div>
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
                        <h4>Edit Attribute</h4>
                    </div>
                    <form action="{{ route('admin.product.attributes.update', $attribute->id) }}" method="POST"
                          enctype="multipart/form-data">
                    @csrf
                    @method('PUT') <!-- Important for form method spoofing -->
                        <div class="card-body">
                            <!-- Name Field -->
                            <div class="row">
                                <div class=" col-md-6 col-sm-12 form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" value="{{ $attribute->name }}"
                                           class="form-control @error('name') is-invalid @enderror">
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-sm-12 form-group">
                                    <div id="values-reapeater">
                                        <div data-repeater-list="values">
                                            @foreach(json_decode($attribute->values) as $value)
                                                <div data-repeater-item>
                                                    <div class="form-group row mb-0">
                                                        <div class=" col-md-3 col-sm-10 form-group">
                                                            <label>Color</label>
                                                            <input type="text" name="color" value="{{ old('color', $value->color) }}"
                                                                   class="form-control color-picker"
                                                                   data-kt-repeater="color-picker">
                                                        </div>
                                                        <div class="col-md-5 col-sm-10 form-group">
                                                            <label class="form-label">Name</label>
                                                            <input class="form-control" name="name" value="{{ old('name', $value->name) }}"/>
                                                        </div>
                                                        <div class="col-md-2 col-sm-10 form-group">
                                                            <label class="form-label">Default</label>
                                                            <div class="py-1">
                                                                <label class="custom-switch">
                                                                    <input type="checkbox" name="default"
                                                                           class="custom-switch-input set_default" {{ isset($value->default) ? 'checked' : ''}}>
                                                                    <span class="custom-switch-indicator"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 form-group mt-auto">
                                                            <a href="javascript:;" data-repeater-delete
                                                               class="btn btn-danger">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <a href="javascript:;" data-repeater-create class="btn btn-primary">
                                            <i class="fa fa-plus"></i>
                                            Add
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit and Reset Buttons -->
                        <div class="card-footer text-right">
                            <button class="btn btn-primary mr-1" type="submit">Submit</button>
                            <a class="btn btn-secondary" href="{{ route('admin.product.attributes.index') }}">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('custom-scripts')
    <script src="{{ asset('plugins/repeater/repeater.js') }}"></script>
    <script>
        $(document).on('click', '.set_default', function () {
            if ($(this).is(':checked')) {
                $('.set_default').each(function () {
                    // Uncheck all other checkboxes except the clicked one
                    if ($(this).get(0) !== $(event.target).get(0)) {
                        $(this).prop('checked', false);
                    }
                });
            }
        });
        $(document).ready(function () {
            $('.color-picker').colorpicker();
            $('#values-reapeater').repeater({
                initEmpty: false,

                show: function () {
                    // Slide down and make the element visible
                    $(this).slideDown();
                    // Re-init color picker or any other plugins
                    $(this).find('[data-kt-repeater="color-picker"]').colorpicker();
                },

                hide: function (deleteElement) {
                    $(this).slideUp(deleteElement);
                },

                ready: function () {
                    // Init color picker on page load
                    $('[data-kt-repeater="color-picker"]').colorpicker();
                }
            });
        });
    </script>
@endpush
