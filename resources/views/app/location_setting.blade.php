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
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="d-flex align-items-center justify-content-between">
                    <h1 class=" display-4">Locations</h1>
                    <a href="javascript:void(0)" class="btn btn-primary btn-sm" data-toggle="modal"
                       data-target="#location">Create Location</a>
                </div>
                <form id="product-attribute-form" method="post"
                      action="{{route('save.location')}}"
                      class="">
                    @sessionToken
                    <div class="modal fade" id="location" tabindex="-1"
                         aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Location</h5>
                                    <button type="button" class="close"
                                            data-dismiss="modal"
                                            aria-label="Close">&times;
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row my-3">
                                        <div class="col-3">
                                            <h1 class="mb-2">Location Name</h1>
                                        </div>
                                        <div class="col-md-9 ">
                                            <input type="text" class="form-control" name="location_name"
                                                   value="">
                                        </div>
                                    </div>

                                    <div class="row my-3">
                                        <div class="col-3">
                                            <h1 class="mb-2">Location ID</h1>
                                        </div>
                                        <div class="col-md-9 ">
                                            <input type="text" class="form-control" name="location_id"
                                                   value="">
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
                </form>
            </div>

            <div class=" col-md-12" style="overflow-x:auto;">
                <table id="datatabled" class="table table-class table-hover">
                    <thead class="border-0 ">
                    <tr class="th-tr table-tr text-center">
                        <th class=" font-weight-bold bg-white text-dark ">Location Name</th>
                        <th class=" font-weight-bold bg-white text-dark ">Location ID</th>
                        <th class=" font-weight-bold bg-white text-dark text-center">Action</th>
                    </tr>
                    </thead>

                    <tbody>
                    @if($locations->count())
                        @foreach($locations as $key => $location)
                            <tr class="td-text-center">
                                <td scope="row">
                                    {{$location->name}}
                                </td>
                                <td scope="row">
                                    {{$location->location_id}}
                                </td>
                                <td scope="row" class="text-center">
                                    <button type="button" data-toggle="modal"
                                            data-target="#edit_location-{{$key}}" class="btn btn-primary btn-sm">Edit</button>
                                    <a href="{{route('delete.location',$location->id)}}" class="btn btn-danger btn-sm">Delete</a>
                                    <form id="product-attribute-form" method="post"
                                          action="{{route('edit.save.location',$location->id)}}"
                                          class="">
                                        @sessionToken
                                        <div class="modal fade" id="edit_location-{{$key}}" tabindex="-1"
                                             aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Location</h5>
                                                        <button type="button" class="close"
                                                                data-dismiss="modal"
                                                                aria-label="Close">&times;
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row my-3">
                                                            <div class="col-3">
                                                                <h1 class="mb-2">Location Name</h1>
                                                            </div>
                                                            <div class="col-md-9 ">
                                                                <input type="text" class="form-control"
                                                                       name="location_name"
                                                                       value="@if(isset($location->name)){{$location->name}}@endif">
                                                            </div>
                                                        </div>

                                                        <div class="row my-3">
                                                            <div class="col-3">
                                                                <h1 class="mb-2">Location ID</h1>
                                                            </div>
                                                            <div class="col-md-9 ">
                                                                <input type="number" class="form-control" name="location_id"
                                                                       value="@if(isset($location)){{$location->location_id}}@endif">
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
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="text-center">No Location Found</td>
                        </tr>
                    @endif
                    </tbody>
                </table>

            </div>

        </div>


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
