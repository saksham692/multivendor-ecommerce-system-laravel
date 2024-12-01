<div class="tab-pane fade show active p-0" id="main-banner" role="tabpanel" aria-labelledby="main-banner-setting">
    <div class="card border">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="text-right">
                        <button type="button" class="btn btn-primary" id="add-main-banner">Add new Banner</button>
                    </div>
                </div>
                <div class="col-12 pt-3">
                    <div class="table-responsive">
                        <table class="table dataTable no-footer" id="main-banner-table">
                            <thead>
                            <tr>
                                <th scope="col">Order</th>
                                <th scope="col">Banner</th>
                                <th scope="col">Url</th>
                                <th scope="col">Options</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($mainBanners as $mainBanner)
                                <tr>
                                    <td class="order-number">{{ $mainBanner->ordering }}</td>
                                    <td>
                                        <img width='200px'
                                             src='{{ asset('storage/'.json_decode($mainBanner->value)->banner) }}'
                                             class='rounded-0'
                                             alt='logo'>
                                    </td>
                                    <td>
                                        <a href="{{ json_decode($mainBanner->value)->url }}" target="_blank">Click
                                            here</a>
                                    </td>
                                    <td>
                                        <div class="buttons">
                                            {{--                                                <button type="button"--}}
                                            {{--                                                   class="btn btn-icon btn-primary edit-main-banner-btn" data-id="{{$mainBanner->id}}"><i class="far fa-edit"></i></button>--}}
                                            <a href="javascript:void(0);"
                                               class="btn btn-icon btn-danger delete-main-banner-btn"
                                               data-id="{{$mainBanner->id}}"><i
                                                    class="fas fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('modal')
    <!-- Add Banner -->
    <div class="modal fade add-main-banner-modal" id="add-main-banner-modal" data-backdrop="static"
         data-keyboard="false" tabindex="-1"
         aria-labelledby="add-main-banner-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="add-main-banner-label">Add banner</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" id="add-main-banner-form">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group row mb-0">
                            <div class="col-sm-12 form-group">
                                <label>Banner</label>
                                <input type="file" name="banner" id="banner"
                                       class="form-control"/>
                                <span id="banner-error" class="error text-danger"></span>
                                <!-- Image Preview Container -->
                                {{--                                <div id="imagesPreviewContainer" class="image-preview-container"></div>--}}
                            </div>
                            <div class="col-sm-12 form-group">
                                <label class="form-label">URL</label>
                                <input class="form-control" type="text" name="url"
                                       value="{{ old('url') }}"/>
                                <span id="url-error" class="error text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Add</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Banner -->
    {{--<div class="modal fade edit-main-banner-modal" id="edit-main-banner-modal" data-backdrop="static"--}}
    {{--     data-keyboard="false" tabindex="-1"--}}
    {{--     aria-labelledby="edit-main-banner-label" aria-hidden="true">--}}
    {{--    <div class="modal-dialog modal-dialog-centered modal-lg">--}}
    {{--        <div class="modal-content">--}}
    {{--            <div class="modal-header">--}}
    {{--                <h5 class="modal-title" id="edit-main-banner-label">Edit banner</h5>--}}
    {{--                <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
    {{--                    <span aria-hidden="true">&times;</span>--}}
    {{--                </button>--}}
    {{--            </div>--}}
    {{--            <form action="#" id="edit-main-banner-form">--}}
    {{--                @csrf--}}
    {{--                <div class="modal-body" id="edit-main-banner-content">--}}
    {{--                </div>--}}
    {{--                <div class="modal-footer">--}}
    {{--                    <button type="submit" class="btn btn-primary">Update</button>--}}
    {{--                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>--}}
    {{--                </div>--}}
    {{--            </form>--}}
    {{--        </div>--}}
    {{--    </div>--}}
    {{--</div>--}}

@endsection
