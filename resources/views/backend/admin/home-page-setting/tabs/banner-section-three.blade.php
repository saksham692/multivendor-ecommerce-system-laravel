<div class="tab-pane fade p-0" id="banner-section-three" role="tabpanel" aria-labelledby="banner-section-three-setting">
    <div class="card border">
        <div class="card-body">
            <form action="{{ route('home-page-setting.banner-section-three') }}" method="POST"
                  enctype="multipart/form-data" id="banner-section-three-form">
                @csrf
                {{--                @method('PUT')--}}
                @php
                    if (!is_null($bannerSectionThree)){
                        $data = json_decode($bannerSectionThree->value);
                        $value['status'] = $data->status;
                        $value['banner'] = $data->banner;
                        $value['url'] = $data->url;
                    }else{
                        $value['status'] = 0;
                        $value['banner'] = 'abc';
                        $value['url'] = '';
                    }
                @endphp
                <div class="form-group">
                    <label for="">Status</label>
                    <br>
                    <label class="custom-switch mt-2">
                        <input type="checkbox" name="status" class="custom-switch-input" {{$value['status'] == 1 ? 'checked' : ''}}>
                        <span class="custom-switch-indicator"></span>
                    </label>
                </div>
                <div class="form-group">
                    <label for="">Preview</label>
                    <br>
                    <img src="{{ get_image($value['banner']) }}" id="banner-section-three-preview" alt="" width="150px">
                </div>
                <div class="form-group">

                    <label>Banner Image</label>
                    <input type="file" class="form-control" name="banner" value="">
                    <span class="error text-danger" id="banner-section-three-banner-error"></span>
                    <input type="hidden" class="form-control" id="banner-section-three-old-banner" name="banner_old" value="{{$value['banner']}}">
                </div>
                <div class="form-group">
                    <label>Banner url</label>
                    <input type="text" class="form-control" name="url" value="{{ $value['url'] }}">
                    <span class="error text-danger" id="banner-section-three-url-error"></span>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
