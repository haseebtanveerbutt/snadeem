@extends('app.layout.default')
<link rel="stylesheet" type="text/css" href="{{asset('coloris/dist/coloris.min.css')}}">
<style>


    tags.tagify.form-control.tagify--noTags.tagify--empty {
        padding-top: 0 !important;
    }

    tags.tagify.form-control {
        display: flex !important;
    }
</style>

<link rel="stylesheet" href="{{asset('tagify-master/tagify.css')}}">
<script src="{{asset('tagify-master/tagify.min.js')}}"></script>
@section('content')

    <div class="container">

        <form id="email_setting" method="post" action="{{route('smtp.setting.save')}}"
              class="col-md-12">
            @sessionToken
            <div class="row">
                <div class="col-lg-12 col-md-12 ">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="mt-3">SMTP Settings</h5>
                        <div>
                            <button type="submit"
                                    class="btn btn-primary btn-sm">Save Settings
                            </button>
                        </div>
                    </div>

                    <div class="row my-3">
                        <div class="col-3">
                            <h1 class="display-4">Suppliers Emails</h1>
                        </div>
                        <div class="col-md-9 card">
                            <div class="card-body">
                                <h1 class="mb-2">Emails</h1>
                                <input type="text" class="form-control" name="email"
                                       value="@if(isset($admin_emails)){{$admin_emails->email}}@endif">
                            </div>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col-3">
                            <h1 class="display-4">SMTP Configurations</h1>
                        </div>
                        <div class="col-md-9 card">
                            <div class="card-body">
                                <h1 class="mb-2">Sender Name</h1>
                                <input type="text"
                                       value="{{isset($setting->smtp_sender_name)?$setting->smtp_sender_name:null}}"
                                       name="smtp_sender_name"
                                       class="form-control " id="sender_name">
                                <h1 class="mb-2 mt-3">Encryption Type</h1>
                                <select class="form-control" name="smtp_encryption">
                                    <option value="tls"
                                            @if(isset($setting->smtp_encryption) && $setting->smtp_encryption == "tls") selected @endif>
                                        TLS
                                    </option>
                                    <option value="ssl"
                                            @if(isset($setting->smtp_encryption) && $setting->smtp_encryption == "ssl") selected @endif>
                                        SSL
                                    </option>
                                </select>
                                <h1 class="mb-2 mt-3">Email From</h1>
                                <input type="text"
                                       value="{{isset($setting->smtp_set_from)?$setting->smtp_set_from:null}}"
                                       name="smtp_set_from"
                                       class="form-control " id="set_form">
                                <h1 class="mb-2 mt-3">Host</h1>
                                <input type="text"
                                       value="{{isset($setting->smtp_host)?$setting->smtp_host:null}}"
                                       name="smtp_host" class="form-control "
                                       id="smtp_host">
                                <h1 class="mb-2 mt-3">Port</h1>
                                <input type="text"
                                       value="{{isset($setting->smtp_post)?$setting->smtp_post:null}}"
                                       name="smtp_post" class="form-control "
                                       id="smtp_post">
                                <h1 class="mb-2 mt-3">Mail Account</h1>
                                <input type="text" name="smtp_mail"
                                       value="{{isset($setting->smtp_mail)?$setting->smtp_mail:null}}"
                                       class="form-control " id="smtp_mail">
                                <h1 class="mb-2 mt-3">Password</h1>
                                <input type="text" name="smtp_password"
                                       value="{{isset($setting->smtp_password)?$setting->smtp_password:null}}"
                                       class="form-control " id="smtp_password">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection
<style>
    .list-group-item a {
        color: white !important;
    }
</style>
@section('script')
    <script type="text/javascript" src="{{asset('coloris/dist/coloris.min.js')}}"></script>
    <script type="text/javascript">

        Coloris({
            el: '.coloris',
            swatches: [
                '#264653',
                '#2a9d8f',
                '#e9c46a',
                '#f4a261',
                '#e76f51',
                '#d62828',
                '#023e8a',
                '#0077b6',
                '#0096c7',
                '#00b4d8',
                '#48cae4'
            ]
        });

    </script>
    <script type="text/javascript">
        $('#summernote').summernote({
            height: 200
        });
    </script>
    <script>
        $(document).ready(function () {
            $('.list-group-item a').click(function () {
                $(this).parent('.list-group-item').css('background', 'white !important');
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            // The DOM element you wish to replace with Tagify
            var input = document.querySelector('input[name=email]');
            // initialize Tagify on the above input node reference
            new Tagify(input)

            var input2 = document.querySelector('input[name=name]');
            // initialize Tagify on the above input node reference
            new Tagify(input2)

            // $(document).on('change', '.status-switch', function () {
            //
            //     var status = '';
            //     var shop_id = $('.shop-id').val();
            //     if ($(this).is(':checked')) {
            //         status = 1;
            //     } else {
            //         status = 0;
            //     }
            //
            //     $.ajax({
            //         url: $(this).data('route'),
            //         type: 'get',
            //         data: {
            //             status: status, shop_id: shop_id
            //         }, success: function (response) {
            //             if (response.status == 'success') {
            //                 toastr.success("Successfully save !");
            //             } else {
            //                 toastr.error("Not save !");
            //             }
            //         }
            //     })
            // });
        });
    </script>
@endsection
