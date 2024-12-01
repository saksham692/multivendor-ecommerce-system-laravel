@extends('backend.admin.layouts.main')
@section('title', 'Home Page Settings')
@section('breadcrumb')
    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
    <div class="breadcrumb-item">Home Page Setting</div>
@endsection
@push('style')
@endpush
@section('content')
    <!-- Main Content -->
    <section class="section">

        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-body">
                            <div class="row">
                                <div class="col-2">
                                    <div class="list-group" id="list-tab" role="tablist">
                                        <a class="list-group-item list-group-item-action active"
                                           id="main-banner-setting"
                                           data-toggle="list" href="#main-banner" role="tab">Main Banner</a>
                                        <a class="list-group-item list-group-item-action"
                                           id="banner-section-one-setting"
                                           data-toggle="list" href="#banner-section-one" role="tab">Banner Section One</a>

                                        <a class="list-group-item list-group-item-action" id="banner-section-two-setting"
                                           data-toggle="list" href="#banner-section-two" role="tab">Banner Section Two</a>

                                        <a class="list-group-item list-group-item-action" id="banner-section-three-setting"
                                           data-toggle="list" href="#banner-section-three" role="tab">Banner Section Three</a>

                                        <a class="list-group-item list-group-item-action" id="banner-section-four-setting"
                                           data-toggle="list" href="#banner-section-four" role="tab">Banner Section Four</a>

                                    </div>
                                </div>
                                <div class="col-10">
                                    <div class="tab-content" id="nav-tabContent">

                                        @include('backend.admin.home-page-setting.tabs.main-banner')

                                        @include('backend.admin.home-page-setting.tabs.banner-section-one')

                                        @include('backend.admin.home-page-setting.tabs.banner-section-two')

                                        @include('backend.admin.home-page-setting.tabs.banner-section-three')

                                        @include('backend.admin.home-page-setting.tabs.banner-section-four')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

@endsection
@push('custom-scripts')
    <script src="{{ asset('plugins/repeater/repeater.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            // $('.select-picker').select2()
            <!-- Main Banner Page Scripts-->
            $('#add-main-banner').on('click', function () {
                $('#add-main-banner-modal').modal('toggle')
            });
            $('#add-main-banner-form').on('submit', function (event) {
                event.preventDefault(); // Correctly prevent default behavior

                var formData = new FormData(this); // Serialize form data

                $.ajax({
                    url: '{{ route('admin.home-page-setting.add-main-banner') }}', // Replace with your correct URL
                    method: 'POST',
                    contentType: false, // Required for FormData
                    processData: false, // Required for FormData
                    data: formData,
                    success: function (response) {
                        if (response.status === "success") {
                            $('#main-banner-table tbody').append(`
                    <tr>
                        <td class="order-number">${response.data.ordering}</td>
                        <td>
                            <img width='200px' src="${response.banner}" class='rounded-0' alt='logo'>
                        </td>
                        <td><a href="${response.url}" target="_blank">Click here</a></td>
                        <td>
                            <div class="buttons">
                                <a href="javascript:void(0);"
                                   class="btn btn-icon btn-danger delete-btn delete-main-banner-btn"
                                   data-id="${response.data.id}">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                `);
                            $('#add-main-banner-form')[0].reset();
                            $('#add-main-banner-modal').modal('toggle')
                        }
                    },
                    error: function (response) {
                        if (response.status === 422) {
                            // Handle validation errors
                            var errors = response.responseJSON.errors;
                            for (let field in errors) {
                                $(`#${field}-error`).text(errors[field][0]); // Display error for each field
                            }
                        } else {
                            // Show a general error message
                            alert('An error occurred while adding the banner. Please try again.');
                        }
                    }
                });
            });
            <!-- Edit Main Banner -->
            {{--$(document).on('click', '.edit-main-banner-btn', function () {--}}
            {{--    $.ajax({--}}
            {{--        url: '{{ route('admin.home-page-setting.edit-main-banner') }}', // Replace with your correct URL--}}
            {{--        method: 'POST',--}}
            {{--        // contentType: false, // Required for FormData--}}
            {{--        // processData: false, // Required for FormData--}}
            {{--        dataType: 'json',--}}
            {{--        data: {--}}
            {{--            _token:'{{ csrf_token() }}',--}}
            {{--            id: $(this).data('id')--}}
            {{--        },--}}
            {{--        success: function (response) {--}}
            {{--            if (response.status === "success") {--}}
            {{--                $('#edit-main-banner-content').html(response.html);--}}
            {{--                $('#edit-main-banner-modal').modal('toggle')--}}
            {{--            }--}}
            {{--        },--}}
            {{--        error: function (response) {--}}
            {{--            // Show a general error message--}}
            {{--                alert('An error occurred while adding the banner. Please try again.');--}}
            {{--        }--}}
            {{--    });--}}
            {{--});--}}
            $(document).on('click', '.delete-main-banner-btn', function (e) {
                e.preventDefault();

                // Confirm deletion
                if (!confirm('Are you sure you want to delete this banner?')) return;

                // Get the banner ID and current row
                var bannerId = $(this).data('id');
                var row = $(this).closest('tr'); // Get the row containing the delete button

                $.ajax({
                    url: '{{ route('home-page-setting.remove-main-banner') }}', // Update with your actual route URL
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}', // Include CSRF token
                        id: bannerId
                    },
                    success: function (response) {
                        if (response.status === 'success') {
                            alert(response.message);

                            // Remove the row from the table
                            row.remove();

                            // Optionally reorder the table or refresh the page if necessary
                            // Example: Update the ordering of visible rows
                            $('#main-banner-table tbody tr').each(function (index) {
                                $(this).find('.order-number').text(index + 1); // Assuming you have a column for order numbers
                            });
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function (xhr) {
                        var response = xhr.responseJSON;
                        alert(response.message || 'An error occurred while deleting the banner.');
                    }
                });
            });


            <!-- Main Banner Page Scripts Ends-->
            <!-- Banner Section One Scripts-->
            $('#banner-section-one-form').on('submit', function (e) {
                $(`#banner-section-one-banner-error`).text('')
                $(`#banner-section-one-url-error`).text('')
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: '{{ route('home-page-setting.banner-section-one') }}',
                    method: 'POST',
                    contentType: false, // Required for FormData
                    processData: false, // Required for FormData
                    data: formData,
                    success: function (response) {
                        if (response.status === 'success') {
                            toastr.success(response.message);
                            $('#banner-section-one-preview').attr('src', response.bannerPath);
                            $('#banner-section-one-old-banner').val(response.banner);
                        }
                    },
                    error: function (xhr) {
                        if (xhr.status === 422) {
                            // Display validation errors
                            let errors = xhr.responseJSON.errors;
                            for (let field in errors) {
                                $(`#banner-section-one-${field}-error`).text(errors[field][0]);
                            }
                        } else {
                            alert('An unexpected error occurred.');
                        }
                    }
                });
            });
            <!-- Banner Section One Scripts Ends-->
            <!-- Banner Section Two Scripts-->
            $('#banner-section-two-form').on('submit', function (e) {
                $(`#banner-section-two-banner_one-error`).text('')
                $(`#banner-section-two-banner_two-error`).text('')
                $(`#banner-section-two-banner_one_url-error`).text('')
                $(`#banner-section-two-banner_two_url-error`).text('')
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: '{{ route('home-page-setting.banner-section-two') }}',
                    method: 'POST',
                    contentType: false, // Required for FormData
                    processData: false, // Required for FormData
                    data: formData,
                    success: function (response) {
                        if (response.status === 'success') {
                            toastr.success(response.message);
                            $('#banner-section-two-banner-one-old').val(response.bannerOne);
                            $('#banner-section-two-banner-one-preview').attr('src', response.bannerOnePath);
                            $('#banner-section-two-banner-two-old').val(response.bannerTwo);
                            $('#banner-section-two-banner-two-preview').attr('src', response.bannerTwoPath);
                        }
                    },
                    error: function (xhr) {
                        if (xhr.status === 422) {
                            // Display validation errors
                            let errors = xhr.responseJSON.errors;
                            for (let field in errors) {
                                $(`#banner-section-two-${field}-error`).text(errors[field][0]);
                            }
                        } else {
                            alert('An unexpected error occurred.');
                        }
                    }
                });
            });
            <!-- Banner Section Two Scripts Ends-->
            <!-- Banner Section Three Scripts-->
            $('#banner-section-three-form').on('submit', function (e) {
                $(`#banner-section-three-banner-error`).text('')
                $(`#banner-section-three-url-error`).text('')
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: '{{ route('home-page-setting.banner-section-three') }}',
                    method: 'POST',
                    contentType: false, // Required for FormData
                    processData: false, // Required for FormData
                    data: formData,
                    success: function (response) {
                        if (response.status === 'success') {
                            toastr.success(response.message);
                            $('#banner-section-three-preview').attr('src', response.bannerPath);
                            $('#banner-section-three-old-banner').val(response.banner);
                        }
                    },
                    error: function (xhr) {
                        if (xhr.status === 422) {
                            // Display validation errors
                            let errors = xhr.responseJSON.errors;
                            for (let field in errors) {
                                $(`#banner-section-three-${field}-error`).text(errors[field][0]);
                            }
                        } else {
                            alert('An unexpected error occurred.');
                        }
                    }
                });
            });
            <!-- Banner Section Three Scripts Ends-->
            <!-- Banner Section Four Scripts-->
            $('#banner-section-four-form').on('submit', function (e) {
                $(`#banner-section-four-banner_one-error`).text('')
                $(`#banner-section-four-banner_two-error`).text('')
                $(`#banner-section-four-banner_one_url-error`).text('')
                $(`#banner-section-four-banner_two_url-error`).text('')
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: '{{ route('home-page-setting.banner-section-four') }}',
                    method: 'POST',
                    contentType: false, // Required for FormData
                    processData: false, // Required for FormData
                    data: formData,
                    success: function (response) {
                        if (response.status === 'success') {
                            toastr.success(response.message);
                            $('#banner-section-four-banner-one-old').val(response.bannerOne);
                            $('#banner-section-four-banner-one-preview').attr('src', response.bannerOnePath);
                            $('#banner-section-four-banner-two-old').val(response.bannerTwo);
                            $('#banner-section-four-banner-two-preview').attr('src', response.bannerTwoPath);
                        }
                    },
                    error: function (xhr) {
                        if (xhr.status === 422) {
                            // Display validation errors
                            let errors = xhr.responseJSON.errors;
                            for (let field in errors) {
                                $(`#banner-section-four-${field}-error`).text(errors[field][0]);
                            }
                        } else {
                            alert('An unexpected error occurred.');
                        }
                    }
                });
            });
            <!-- Banner Section Four Scripts Ends-->
        });
    </script>

@endpush
