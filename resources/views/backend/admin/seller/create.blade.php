@extends('backend.admin.layouts.main')
@section('title', 'New Seller')
@section('breadcrumb')
    <div class="breadcrumb-item"><a href="#">Sellers</a></div>
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
                        <h4>New Seller</h4>
                    </div>
                    <form action="{{ route('sellers.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <!-- Name Field -->
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control @error('name') 'is-invalid' @enderror"
                                       name="name" value="{{ old('name') }}">
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="text" class="form-control @error('email') 'is-invalid' @enderror"
                                               name="email" value="{{ old('email') }}">
                                        @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input type="text" class="form-control @error('phone') 'is-invalid' @enderror"
                                               name="phone" value="{{ old('phone') }}">
                                        @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password"
                                               class="form-control @error('password') 'is-invalid' @enderror"
                                               name="password" value="{{ old('password') }}">
                                        @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Confirm password</label>
                                        <input type="password"
                                               class="form-control @error('password_confirmation') 'is-invalid' @enderror"
                                               name="password_confirmation" value="{{ old('password_confirmation') }}">
                                        @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="role" value="seller">
                            <div class="form-group">
                                <label>Shop Name</label>
                                <input type="text" class="form-control @error('shop_name') 'is-invalid' @enderror"
                                       name="shop_name" value="{{ old('shop_name') }}">
                                @error('shop_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea type="text" class="form-control @error('description') 'is-invalid' @enderror"
                                          name="description" value="{{ old('description') }}"></textarea>
                                @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <textarea type="text" class="form-control @error('address') 'is-invalid' @enderror"
                                          name="address" value="{{ old('address') }}"></textarea>
                                @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Country</label>
                                        <select class="form-control select2" name="country_id" id="country_id">
                                            <option value="">Select Country</option>
                                            @foreach(\App\Models\Country::all() as $country)
                                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                                            @endforeach
                                            @error('country_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>State</label>
                                        <select class="form-control select2" name="state_id" id="state_id">
                                        </select>
                                        @error('state_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>City</label>
                                        <select class="form-control select2" name="city_id" id="city_id">
                                        </select>
                                        @error('city_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit and Reset Buttons -->
                        <div class="card-footer text-right">
                            <button class="btn btn-primary mr-1" type="submit">Submit</button>
                            <a class="btn btn-secondary" href="{{ route('sellers.index') }}">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('custom-scripts')
    <script>
        $(document).ready(function () {
           $('#country_id').on('change', function () {
               var country_id = $(this).val();
               if (country_id) {
                   $.ajax({
                       url: '{{ route('get.states') }}',
                       method: 'POST',
                       dataType: 'json',
                       data: {
                           _token: '{{ csrf_token() }}',
                           country_id: country_id,
                       },
                       success: function (response) {
                           $('#state_id').empty();
                           $('#state_id').append('<option value="">Select State</option>');
                           $.each(response, function (key, value) {
                               $('#state_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                           });
                       },
                       error: function (response) {
                           toastr.error("An error occurred while fetching states.", "Error");
                       }
                   });
               }
           });
           $('#state_id').on('change', function () {
               var state_id = $(this).val();
               if (state_id) {
                   $.ajax({
                       url: '{{ route('get.cities') }}',
                       method: 'POST',
                       dataType: 'json',
                       data: {
                           _token: '{{ csrf_token() }}',
                           state_id: state_id,
                       },
                       success: function (response) {
                           $('#city_id').empty();
                           $('#city_id').append('<option value="">Select City</option>');
                           $.each(response, function (key, value) {
                               $('#city_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                           });
                       },
                       error: function (response) {
                           toastr.error("An error occurred while fetching cities.", "Error");
                       }
                   });
               }
           });
        });
    </script>
@endpush
