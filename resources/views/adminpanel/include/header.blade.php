{{--Header Start--}}
    <!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
{{--    <link rel="icon" type="image/png" sizes="26x26" href="{{asset('text-global-uk.jpg')}}">--}}
    <title>Omnie - Branded Live Support APP</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('custom_assets/css/style.css')}}?{{ now() }}">
    <!-- <link rel="stylesheet" href="http://localhost:3000/css/bootstrap4/dist/css/bootstrap-custom.css?v=datetime"> -->
    <link rel="stylesheet" href="{{asset('polished_asset/polished.min.css')}}">
    <!-- <link rel="stylesheet" href="polaris-navbar.css"> -->
    <link rel="stylesheet" href="{{asset('polished_asset/iconic/css/open-iconic-bootstrap.min.css')}}">
{{--select2 css--}}
    <link rel="stylesheet" href="{{ asset('polished_asset/select2/css/select2.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/bootstrap-polaris.min.css') }}">
    {{--    toaster cdn to display response--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
{{--    ckeditor cdn--}}
    <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>

    <link rel="stylesheet" type="text/css" href="{{asset('daterangepicker-master/daterangepicker.css')}}"/>

    <style>
        .daterangepicker.ltr.show-ranges.opensleft {
            top: 56px !important;
        }
    </style>



</head>
<style>
    .dropdown-menu.show {
        left: 70px !important;
    }
    button.dropdown-item {
        padding: 10px 14px !important;
    }
    .dropdown-item:focus, .dropdown-item:hover {
        color: #171e26;
        text-decoration: none;
        background-color: #f9fafb;
        padding: 10px 14px !important;
        cursor: pointer !important;
    }
    .card{
        border: 0 !important;
    }
    .active-line{
        border-bottom: 2px solid white !important;
    }
    .navbar {
        padding: 10px 20px !important;
    }

    .container {
        max-width: 1340px !important;
    }

    .navbar-brand {
        padding-top: 0;
        padding-bottom: 0;
        font-size: 20px !important;
    }
    ul.custom-ul li {
        font-size: 14.4px !important;
    }
    .navbar {
        padding: 0 1rem;
    }

    h3, .h3 {
        font-size: 28px !important;
    }
    h4, .h4{
        font-size: 24px !important;
    }
    h5, .h5{
        font-size: 20px !important;
    }
    h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 {
        margin-bottom: 8px !important;
        font-family: inherit !important;
        font-weight: 500 !important;
        line-height: 1.2 !important;
        color: inherit !important;
    }
    .fw-normal {
        font-weight: normal !important;
    }
    .fw-bold {
        font-weight: bold !important;
    }
    small, .small {
        font-size: 16px !important;
    }
    p{
        margin-bottom: 16px !important;
    }
    .mb-2, .my-2 {
        margin-bottom: 8px !important;
    }
</style>


{{--Header End--}}
