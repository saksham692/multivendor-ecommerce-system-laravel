<meta charset="UTF-8">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
<title>Dashboard &mdash; Stisla</title>

<!-- General CSS Files -->
<link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">

<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('assets/modules/jqvmap/dist/jqvmap.min.css') }}">
<link rel="stylesheet" href="{{asset('assets/modules/weather-icon/css/weather-icons.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/modules/weather-icon/css/weather-icons-wind.min.css')}}">
<link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/toastr/build/toastr.css') }}">
<link rel="stylesheet" href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="{{asset('assets/css/bootstrap-iconpicker.min.css')}}">
{{--<link rel="stylesheet" href="{{ asset('plugins/color-picker/bootstrap-colorpicker.css') }}">--}}
<link rel="stylesheet" href="{{asset('assets/modules/bootstrap-daterangepicker/daterangepicker.css')}}">
<link rel="stylesheet" href="{{asset('assets/modules/select2/dist/css/select2.min.css')}}">

@stack('page-specific-css')
<!-- Template CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
{{--@vite(['resources/js/app.js', 'resources/js/admin.js'])--}}

<style>
    .invalid-feedback{
        display: block;
    }
    .image-preview-container {
        display: flex;
        flex-wrap: wrap;
        margin-top: 10px;
    }

    .image-preview {
        width: 100px;
        height: 100px;
        border: 2px solid #dddddd;
        margin-right: 10px;
        margin-bottom: 10px;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: visible;
        background: rgba(69, 68, 68, 0.5);
        padding: .5rem;
    }

    .image-preview img {
        width: 100%;
        height: 100%;
        /*height: auto;*/
        object-fit: contain;
    }

    .remove-image {
        position: absolute;
        top: -10px;
        right: -10px;
        background-color: rgba(69, 68, 68);
        border: none;
        font-size: 14px;
        cursor: pointer;
        padding: 0;
        border-radius: 14px;
        width: 28px;
        height: 28px;
    }
</style>
