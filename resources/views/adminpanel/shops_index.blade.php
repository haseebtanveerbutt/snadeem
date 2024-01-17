@extends('adminpanel.layout.default')
<style>
    .slider.round {
        color: transparent !important;
    }

    .shop-status-btn {
        text-decoration: none !important;
    }

    .card-header {
        padding: 2rem 2rem 1rem 2rem !important;
        margin-bottom: 0;
    }

    .shop-status-btn:hover {
        text-decoration: none !important;
    }
</style>
@section('content')

    <div class="container">
        <div class="col-lg-12 col-md-12 p-4">
            <!-- start info box -->
            <div class="row mt-0">
                <div class="col-md-12 pl-3 pt-2" style="margin: auto;">
                    <h5 class="mb-4">Shops</h5>
                    <div class="card" style="width: 100%">
                        <div class="card-body">
                            <div id="product_append">
                                <form method="get" action="{{route('shops')}}">

                                    <div class="row no-margins card-body-section">

                                        <div class="col-md-10">
                                            <input name="search" value="@if(isset($search)){{$search}}@endif"
                                                   class="form-control "
                                                   placeholder="e.g test.myshopify.com">
                                        </div>
                                        <div class="col-md-2 btn-group">
                                            <button class="btn btn-primary @if(isset($search)) w-50 @else w-100  @endif">Search</button>
                                            @if(isset($search))
                                                <a href="{{route('shops')}}" class="btn w-50 btn-primary ">Reset</a>
                                            @endif
                                        </div>

                                    </div>
                                </form>
                                <div class="row px-3" style="overflow-x:auto;margin-top: 0; margin-bottom: 0;">

                                    <table id="datatabled" class="table table-borderless  table-hover  table-class ">
                                        <thead class="border-0 ">

                                        <tr class="th-tr table-tr text-center">
                                            <th class="font-weight-bold ">Shop Name</th>
                                            <th class="font-weight-bold ">Plan Name</th>
                                            {{--                                            <th class="font-weight-bold " >Credits</th>--}}
                                            {{--                                            <th class="font-weight-bold " >Shop Status</th>--}}
                                            <th class="font-weight-bold text-right pr-3">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        {{--                                        @dd($users_data)--}}
                                        @if($users_data->count())
                                            @foreach($users_data as $key=>$user)

                                                <tr class="td-text-center">
                                                    <td style="vertical-align: middle;">
                                                        <a href={{route('admin.orders',$user->id)}}>
                                                            {{$user->name}}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        @if(isset($user->plan->name))
                                                            <div
                                                                class="badge badge--success ">{{$user->plan->name}}</div>
                                                        @else
                                                            <div class="badge badge--warning ">No Plan Selected</div>
                                                        @endif
                                                    </td>
                                                    {{--                                                <td>--}}
                                                    {{--                                                    <div class="  px-3 py-1">{{$user->credit}}</div>--}}
                                                    {{--                                                </td>--}}
                                                    {{--                                                <td>--}}
                                                    {{--                                                    <label class="switch" style="">--}}
                                                    {{--                                                        --}}{{--                                    @dd($shop_data->user)--}}
                                                    {{--                                                        <input--}}
                                                    {{--                                                            @if(isset($user->user_status)  && $user->user_status == "active")checked="" @endif--}}
                                                    {{--                                                        name="user_status"--}}
                                                    {{--                                                            type="checkbox"--}}
                                                    {{--                                                            value="active"--}}
                                                    {{--                                                            data-id="{{$user->id}}"--}}
                                                    {{--                                                            data-route="{{route('StatusSave')}}"--}}
                                                    {{--                                                            class="custom-control-input  status-switch">--}}
                                                    {{--                                                        <span class="slider round"></span>--}}
                                                    {{--                                                    </label>--}}
                                                    {{--                                                </td>--}}
                                                    <td style="text-align: right;vertical-align: middle">
                                                        {{--                                                @if(isset($user->shopdetail) && $user->shopdetail != "")--}}
                                                        <a class="shop-status-btn" href="https://{{$user->name}}"
                                                           target="_blank">
                                                            <button class="btn btn-sm btn-primary">Preview <i style="margin-top: 3px;
    margin-left: 5px;
    font-size: 12px;" class="fas fa-external-link-alt"></i>
                                                            </button>
                                                        </a>
                                                        <a class="shop-status-btn"
                                                           href="{{route('admin.orders',$user->id)}}">
                                                            <button class="btn btn-sm btn-primary">View Detail</button>
                                                        </a>
                                                        {{--                                                @else--}}
                                                        {{--                                                    <div class="badge badge-danger text-light px-3 py-1">No Shop Details</div>--}}
                                                        {{--                                                @endif--}}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="3" class="text-center">
                                                    -- No Shops Found
                                                </td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                    @if($users_data->count())
                                        {!!  $users_data->links() !!}
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $('.slider').text('');
        $('body').on('change', '.status-switch', function () {
            var status = '';
            $('.slider').text('');
            var id = $(this).data('id');

            console.log(id)
            if ($(this).is(':checked')) {
                status = 'active';
                $(this).next().text('Active')
            } else {
                status = 0;
                $(this).next().text('Inactive')
            }
            $.ajax({
                url: $(this).data('route'),
                type: 'get',
                data: {
                    id: id,
                    _token: $(this).data('csrf'),
                    type: 'user_status_update',
                    status: status
                },
                success: function (response) {
                    $('.slider').text('');
                    if (response.status == "success") {
                        toastr.success("Shop status change successfully!")
                    } else {
                        toastr.error("Shop status not change!")
                    }
                }
            })
        });
    });
</script>

