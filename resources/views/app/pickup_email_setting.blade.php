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
        <form id="email_setting" method="post" action="{{route('pickup.email.setting.save')}}"
              class="col-md-12">
            @sessionToken
            <div class="row">
                <div class="col-lg-12 col-md-12 p-2">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class=" mt-2">Pickup Email Template</h5>
                        <div>
                            <button type="submit"
                                    class="btn btn-primary btn-sm">Save Settings
                            </button>
                        </div>
                    </div>

                    <div class="row  mt-4 ">
                        <div class="col-md-3">
                            <h1 class="display-4">Email Settings</h1>
                        </div>
                        <div class="col-md-9 card">
                            <div class="card-body">
                                <h1 class="mb-2">Subject</h1>
                                <input name="pickup_subject" required class="form-control"
                                       value="{{isset($email_setting->pickup_email_subject)?$email_setting->pickup_email_subject:null}}">
                                <h1 class="mb-2 mt-3">Content</h1>
                                <textarea name="pickup_body" class="form-control " id="summernote"
                                          rows="8">@if(isset($email_setting->pickup_email_body)){!! $email_setting->pickup_email_body !!}@endif</textarea>

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
