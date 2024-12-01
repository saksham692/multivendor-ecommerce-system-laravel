<div class="tab-pane fade p-0" id="banner-section-two" role="tabpanel" aria-labelledby="banner-section-two-setting">
    <div class="card border">
        <div class="card-body">
            <form action="{{ route('home-page-setting.banner-section-two') }}" method="POST"
                  enctype="multipart/form-data" id="banner-section-two-form">
                @csrf
                {{--                @method('PUT')--}}
                @php
                    if (!is_null($bannerSectionTwo)){
                        $data = json_decode($bannerSectionTwo->value);
                        $value[0]['status'] = $data[0]->status;
                        $value[0]['banner'] = $data[0]->banner;
                        $value[0]['url'] = $data[0]->url;
                        $value[1]['status'] = $data[1]->status;
                        $value[1]['banner'] = $data[1]->banner;
                        $value[1]['url'] = $data[1]->url;

                    }else{
                        $value[0]['status'] = 0;
                        $value[0]['banner'] = 'abc';
                        $value[0]['url'] = '';
                        $value[1]['status'] = 0;
                        $value[1]['banner'] = 'abc';
                        $value[1]['url'] = '';
                    }
                @endphp
                <h4>Banner One</h4>
                <div class="form-group">
                    <label for="">Status</label>
                    <br>
                    <label class="custom-switch mt-2">
                        <input type="checkbox" name="banner_one_status" class="custom-switch-input" {{$value[0]['status'] == 1 ? 'checked' : ''}}>
                        <span class="custom-switch-indicator"></span>
                    </label>
                </div>
                <div class="form-group">
                    <label for="">Preview</label>
                    <br>
                    <img src="{{ get_image($value[0]['banner']) }}" id="banner-section-two-banner-one-preview" alt="" width="150px">
                </div>
                <div class="form-group">

                    <label>Banner Image</label>
                    <input type="file" class="form-control" name="banner_one" value="">
                    <span class="error text-danger" id="banner-section-two-banner_one-error"></span>
                    <input type="hidden" class="form-control" id="banner-section-two-banner-one-old" name="banner_one_old" value="{{$value[0]['banner'] == 'abc' ? '' : $value[0]['banner']}}">
                </div>
                <div class="form-group">
                    <label>Banner url</label>
                    <input type="text" class="form-control" name="banner_one_url" value="{{ $value[0]['url'] }}">
                    <span class="error text-danger" id="banner-section-two-banner_one_url-error"></span>
                </div>
                <hr>

                <!-- Banner Two Starts -->
                <h4>Banner Two</h4>
                <div class="form-group">
                    <label for="">Status</label>
                    <br>
                    <label class="custom-switch mt-2">
                        <input type="checkbox" name="banner_two_status" class="custom-switch-input" {{$value[1]['status'] == 1 ? 'checked' : ''}}>
                        <span class="custom-switch-indicator"></span>
                    </label>
                </div>
                <div class="form-group">
                    <label for="">Preview</label>
                    <br>
                    <img src="{{ get_image($value[1]['banner']) }}" id="banner-section-two-banner-two-preview" alt="" width="150px">
                </div>
                <div class="form-group">

                    <label>Banner Image</label>
                    <input type="file" class="form-control" name="banner_two" value="">
                    <span class="error text-danger" id="banner-section-two-banner_two-error"></span>
                    <input type="hidden" class="form-control" id="banner-section-two-banner-two-old" name="banner_two_old" value="{{$value[1]['banner'] == 'abc' ? '' : $value[1]['banner']}}">
                </div>
                <div class="form-group">
                    <label>Banner url</label>
                    <input type="text" class="form-control" name="banner_two_url" value="{{ $value[1]['url'] }}">
                    <span class="error text-danger" id="banner-section-two-banner_two_url-error"></span>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
