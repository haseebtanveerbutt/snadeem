@extends('adminpanel.layout.default')
<style>
    .card {
        min-height: 160px !important;
    }

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
        <div class="row">
            <div class="col-lg-12 col-md-12 p-2">
                <h5 class=" mb-4">Settings</h5>
                <div class="row">
                    <form id="product-attribute-form" method="post" action="{{route('setting.save')}}"
                          class="col-md-4">
                        @csrf
                        <div class="">
                            <div class="card radius-10">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h5 class="mb-0 text-secondary">SMTP Settings</h5>
                                            {{--                                                    <p class="my-1">Activation</p>--}}
                                        </div>
                                        {{--                                                <div class=" ms-auto">--}}
                                        {{--                                                    <div class="form-check form-switch">--}}
                                        {{--                                                        <input class="form-check-input status-switch switch" type="checkbox" data-route="{{route('setting.status','type=smptp_setting')}}"--}}
                                        {{--                                                               name="paypal_status" id="paypal_status" value="1" @if(isset($setting->smtp_status) && $setting->smtp_status == 1) checked @endif>--}}
                                        {{--                                                        <label class="form-check-label"--}}
                                        {{--                                                               for="smtp_status"></label>--}}
                                        {{--                                                    </div>--}}
                                        {{--                                                </div>--}}
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <a href="javascript:void(0)" data-toggle="modal"
                                       data-target="#smtp_settings">Configuration <i style="margin-left: 1px;"
                                                                                     class="fas fa-hand-pointer"></i></a>
                                    <div class="modal fade" id="smtp_settings" tabindex="-1"
                                         aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Settings</h5>
                                                    <button type="button" class="close"
                                                            data-dismiss="modal"
                                                            aria-label="Close">&times;
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row my-3">
                                                        <div class="col-3">
                                                            <label class="form-label">Sender Name</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <input type="text"
                                                                   value="{{isset($setting->smtp_sender_name)?$setting->smtp_sender_name:null}}"
                                                                   name="smtp_sender_name"
                                                                   class="form-control " id="sender_name">
                                                        </div>
                                                    </div>
                                                    <div class="row my-3">
                                                        <div class="col-3">
                                                            <label class="form-label">Encryption Type</label>
                                                        </div>
                                                        <div class="col-md-9">
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
                                                        </div>
                                                    </div>
                                                    <div class="row my-3">
                                                        <div class="col-3">
                                                            <label class="form-label">Set From</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <input type="text"
                                                                   value="{{isset($setting->smtp_set_from)?$setting->smtp_set_from:null}}"
                                                                   name="smtp_set_from"
                                                                   class="form-control " id="set_form">
                                                        </div>
                                                    </div>
                                                    <div class="row my-3">
                                                        <div class="col-3">
                                                            <label class="form-label">SMTP Host</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <input type="text"
                                                                   value="{{isset($setting->smtp_host)?$setting->smtp_host:null}}"
                                                                   name="smtp_host" class="form-control "
                                                                   id="smtp_host">
                                                        </div>
                                                    </div>
                                                    <div class="row my-3">
                                                        <div class="col-3">
                                                            <label class="form-label">SMTP Port</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <input type="text"
                                                                   value="{{isset($setting->smtp_post)?$setting->smtp_post:null}}"
                                                                   name="smtp_post" class="form-control "
                                                                   id="smtp_post">
                                                        </div>
                                                    </div>
                                                    <div class="row my-3">
                                                        <div class="col-3">
                                                            <label class="form-label">SMTP Mail Account</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <input type="text" name="smtp_mail"
                                                                   value="{{isset($setting->smtp_mail)?$setting->smtp_mail:null}}"
                                                                   class="form-control " id="smtp_mail">
                                                        </div>
                                                    </div>
                                                    <div class="row my-3">
                                                        <div class="col-3">
                                                            <label class="form-label">SMTP Mail Password</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <input type="text" name="smtp_password"
                                                                   value="{{isset($setting->smtp_password)?$setting->smtp_password:null}}"
                                                                   class="form-control " id="smtp_password">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button"
                                                            class="btn btn-danger btn-sm"
                                                            data-dismiss="modal">Close
                                                    </button>
                                                    <button type="submit"
                                                            class="btn btn-primary btn-sm">Save
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <form id="product-attribute-form" method="post"  action="{{route('admin-email')}}"
                          class="col-md-4">
                        @csrf
                        <div class="">
                            <div class="card radius-10">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h5 class="mb-0 text-secondary">Admin Emails</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <a href="javascript:void(0)" data-toggle="modal"
                                       data-target="#admin_emails">Configuration <i style="margin-left: 1px;"
                                                                                     class="fas fa-hand-pointer"></i></a>
                                    <div class="modal fade" id="admin_emails" tabindex="-1"
                                         aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Admin Emails</h5>
                                                    <button type="button" class="close"
                                                            data-dismiss="modal"
                                                            aria-label="Close">&times;
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row my-3">
                                                        <div class="col-3">
                                                            <label class="form-label">Emails</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" name="email"
                                                                   value="@if(isset($admin_emails)){{$admin_emails->email}}@endif">
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button"
                                                            class="btn btn-danger btn-sm"
                                                            data-dismiss="modal">Close
                                                    </button>
                                                    <button type="submit"
                                                            class="btn btn-primary btn-sm">Save
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>


            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
        $(document).ready(function () {
            // The DOM element you wish to replace with Tagify
            var input = document.querySelector('input[name=email]');
            // initialize Tagify on the above input node reference
            new Tagify(input)
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
