@extends('app.layout.default')
<style>
    .arrow {
        border: solid black;
        border-width: 0 1px 1px 0;
        display: inline-block;
        padding: 3px;
    }

    .order_render_div {
        border: 0 !important;
    }

    .down {
        transform: rotate(45deg);
        -webkit-transform: rotate(45deg);
    }
</style>
<style>
    /* Rating Star Widgets Style */
    .rating-stars ul {
        list-style-type: none;
        padding: 0;

        -moz-user-select: none;
        -webkit-user-select: none;
    }

    .rating-stars ul > li.star {
        display: inline-block;

    }

    /* Idle State of the stars */
    i.fa {
        font-size: 1.125em; /* Change the size of the stars */
        color: #ccc !important; /* Color on idle state */
    }

    /* Selected state of the stars */
    .selected i.fa {
        color: #5B69C3 !important;
    }

    .padding-0 {
        padding: 0 !important;
    }
</style>
<style>
    .input-loader{
        position: absolute;
        right: 15px;
        top: 4px;
        display: none;
    }

    .loader-c {
        border: 4px solid #dcd9d9;
        border-radius: 50%;
        border-top: 4px solid #5c6ac4;
        width: 25px;
        height: 25px;
        -webkit-animation: spin 1s linear infinite;
        animation: spin 1s linear infinite;
    }

    /* Safari */
    @-webkit-keyframes spin {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
@section('content')
    <div class="container" style="min-height: 510px;">

        <div class="col-lg-12 col-md-12 ">
            <!-- start info box -->
            <div class="row ">
                <div class="col-md-12 padding-0 my-2">
                    <div class="d-flex justify-content-between align-items-center"
                         style="margin-bottom: 16px !important;">
                        <h5 style="margin-bottom: 0 !important;">Orders</h5>
                        <div>
{{--                            <a class="btn  btn-primary text-white btn-sm" href="{{route('get_inventory_levels')}}">Inventory Levels</a>--}}
                            <a class="btn  btn-primary text-white btn-sm ml-3" href="{{URL::tokenRoute('sync-shipments')}}">Sync Current Status</a>
                            <a class="btn  btn-primary text-white btn-sm ml-3" href="{{URL::tokenRoute('sync-orders')}}">Sync Orders</a>
                            {{--                            <a class="btn btn-sm btn-primary text-white" href="{{route('sync-products')}}">Sync Products</a>--}}
                            {{--                            <a class="btn btn-sm btn-primary text-white" href="{{route('sync-products')}}">Export</a>--}}
                        </div>
                    </div>
                    <div class="card order_render_div">
                        <div class="card-header-actions">
                            <ul class="card-header-tabs">
{{--                                <li class="card-header-tab">--}}
{{--                                    <a href="javascript:void(0)"--}}
{{--                                       class="@if(isset($selected_filter) && $selected_filter == "pickup") active @endif pickup"--}}
{{--                                       data-filtertype="pickup"--}}
{{--                                       data-shopid="{{$user->id}}">Pickup</a>--}}
{{--                                </li>--}}
{{--                                <li class="card-header-tab">--}}
{{--                                    <a href="javascript:void(0)"--}}
{{--                                       class="@if(isset($selected_filter) && $selected_filter == "delivery") active @endif delivery"--}}
{{--                                       data-filtertype="delivery"--}}
{{--                                       data-shopid="{{$user->id}}">Delivery</a>--}}
{{--                                </li>--}}
                                <li class="card-header-tab">
                                    <a class="@if(isset($selected_filter) && $selected_filter == "all") active @endif   all" data-filtertype="all" href="javascript:void(0)"
                                       data-shopid="{{$user->id}}">All</a>
                                </li>
                                <li class="card-header-tab">
                                    <a href="javascript:void(0)"
                                       class="@if(isset($selected_filter) && $selected_filter =="unfulfilled") active @endif unfulfilled"
                                       data-filtertype="unfulfilled"
                                       data-shopid="{{$user->id}}">Unfulfilled</a>
                                </li>
                                <li class="card-header-tab">
                                    <a href="javascript:void(0)"
                                       class="@if(isset($selected_filter) && $selected_filter =="fulfilled") active @endif fulfilled"
                                       data-filtertype="fulfilled" data-shopid="{{$user->id}}">Fulfilled</a>
                                </li>
                                <li class="card-header-tab">
                                    <a href="javascript:void(0)"
                                       class="@if(isset($selected_filter) && $selected_filter =="partial") active @endif partial"
                                       data-filtertype="partial"
                                       data-shopid="{{$user->id}}">Partial</a>
                                </li>
                                <li class="card-header-tab">
                                    <a href="javascript:void(0)"
                                       class="@if(isset($selected_filter) && $selected_filter =="paid") active @endif paid"
                                       data-filtertype="paid"
                                       data-shopid="{{$user->id}}">Paid</a>
                                </li>
                                <li class="card-header-tab">
                                    <a href="javascript:void(0)"
                                       class="@if(isset($selected_filter) && $selected_filter =="unpaid") active @endif unpaid"
                                       data-filtertype="unpaid"
                                       data-shopid="{{$user->id}}">Unpaid</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">

                            <div class="row no-margins card-body-section">
                                <div class="col-12" style="position:relative;">
                                    <input name="search" class="form-control filter-order-by-search"
                                           data-href="{{route('filter.search.orders',$user->id)}}"
                                           placeholder="Filter Orders e.g #1001">
                                    <div class="loader-c input-loader"></div>
                                </div>
                            </div>

                            <div class="card-body-section table-responsive-wrapper">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
{{--                                        <th scope="col">--}}
{{--                                            <label for="checkAll" class="polaris-check">--}}
{{--                                                <input type="checkbox" name="checkAll" id="checkAll">--}}
{{--                                                <span><span class="sr-only">Select All</span></span>--}}
{{--                                            </label>--}}
{{--                                        </th>--}}
                                        <th scope="col" class="sort">
                                            <a href="#" class="btn btn-link-sort">Order</a>
                                        </th>
                                        <th scope="col" class="sort">
                                            <a href="#" class="btn btn-link-sort active">
                                                Date
                                            </a>
                                        </th>
                                        <th scope="col" class="sort">
                                            <a href="#" class="btn btn-link-sort">Customer</a>
                                        </th>
                                        <th scope="col" class="sort">
                                            <a href="#" class="btn btn-link-sort">Total</a>
                                        </th>
                                        <th scope="col" class="sort">
                                            <a href="#" class="btn btn-link-sort">Payment Status</a>
                                        </th>
                                        <th scope="col" class="sort">
                                            <a href="#" class="btn btn-link-sort">Fulfillment Status</a>
                                        </th>
                                        <th scope="col" class="sort">
                                            <a href="#" class="btn btn-link-sort">Shipment Status</a>
                                        </th>
                                        <th scope="col" class="sort">
                                            <a href="#" class="btn btn-link-sort">Tracking ID</a>
                                        </th>
                                        <th scope="col" class="sort">
                                            <a href="#" class="btn btn-link-sort">Action</a>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($orders->count())
                                        @foreach($orders as $order)
                                            <tr class="td-text-center main-tr" style="cursor: pointer">
{{--                                                <td>--}}
{{--                                                    <label for="check1" class="polaris-check">--}}
{{--                                                        <input type="checkbox" name="check1" id="check1">--}}
{{--                                                        <span><span class="sr-only">Select Item</span></span>--}}
{{--                                                    </label>--}}
{{--                                                </td>--}}
                                                <td>{{$order->name}}
                                                </td>
                                                <td>{{date("M d, Y h:i A ", strtotime( $order->created_at))}}</td>
                                                <td>
                                                    @php
                                                        $customer = null;
                                                        if(isset($order->customer)){
                                                            $customer = json_decode($order->customer);
                                                            $customer = (isset($customer->first_name) ? $customer->first_name : null) . ((isset($customer->last_name) ? ' ' . $customer->last_name : null));

                                                        }
                                                    @endphp
                                                    @if(isset($customer))
                                                        {{ucwords($customer)}}
                                                    @endif
                                                </td>
                                                <td>
                                                    <span>{{$order->currency}}</span> {{number_format($order->total_price,2)}}
                                                </td>
                                                @php
                                                    $shipment_status = null;
                                                    if(isset($order->financial_status)){
                                                        $financial_status = $order->financial_status;
                                                    }
                                                @endphp
                                                <td>
                                                    @if(isset($financial_status))
                                                        <span
                                                            class="badge
                                                            @if($financial_status == 'paid')
                                                                badge--success
                                                            @elseif($financial_status == 'refunded')
                                                                badge--attention
                                                            @else
                                                                badge--warning
                                                            @endif
                                                             ">{{ucwords($financial_status)}}</span>
                                                    @else
                                                        <p class="">--</p>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($order->fulfillment_status == null)
                                                        <div><span class="badge badge--warning">Unfulfilled</span></div>
                                                    @elseif($order->fulfillment_status == 'partial')
                                                        <div><span class="badge badge--attention">Partial Fulfilled</span>
                                                        </div>
                                                    @elseif($order->fulfillment_status == 'fulfilled')
                                                        <div><span class="badge badge--success">Fulfilled</span></div>
                                                    @endif

                                                </td>
                                                <td>
                                                    @if(isset($order->fulfillment_tracking_status))
                                                        {{$order->fulfillment_tracking_status}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(isset($order->fulfillment_tracking_id))
                                                        {{$order->fulfillment_tracking_id}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($order->fulfillment_tracking_id == null && $order->	fulfillment_status != 'fulfilled')
                                                        <a class="btn btn-primary btn-sm" href="{{URL::tokenRoute('fulfillment_on_system',[$order->id])}}">Fulfill</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="text-center" colspan="10">
                                                No Orders Found
                                            </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                                @if($orders->count())
                                    <div class="container-fluid">
                                        <div class="row justify-content-center">
                                            <ul class="pagination">
                                                <li class="page-item">
                                                    <a class="btn  @if($orders->previousPageUrl()) @else disabled @endif"
                                                       href="{{$orders->appends(request()->input())->previousPageUrl()}}" >
                                                          <span class="polaris-icon">
                                                            <svg class="polaris-icon__svg" viewBox="0 0 20 20">
                                                              <path
                                                                  d="M17 9H5.414l3.293-3.293a.999.999 0 1 0-1.414-1.414l-5 5a.999.999 0 0 0 0 1.414l5 5a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414L5.414 11H17a1 1 0 1 0 0-2"
                                                                  fill-rule="evenodd"></path>
                                                            </svg>
                                                          </span>
                                                        <span class="sr-only">Previous</span>
                                                    </a>
                                                </li>
                                                <li class="page-item">
                                                    <a class="btn   @if($orders->nextPageUrl()) @else disabled @endif"
                                                       href="{{$orders->appends(request()->input())->nextPageUrl()}}" >
                                                          <span class="polaris-icon">
                                                            <svg class="polaris-icon__svg" viewBox="0 0 20 20">
                                                              <path
                                                                  d="M17.707 9.293l-5-5a.999.999 0 1 0-1.414 1.414L14.586 9H3a1 1 0 1 0 0 2h11.586l-3.293 3.293a.999.999 0 1 0 1.414 1.414l5-5a.999.999 0 0 0 0-1.414"
                                                                  fill-rule="evenodd"></path>
                                                            </svg>
                                                          </span>
                                                        <span class="sr-only">Next</span>
                                                    </a>
                                                </li>
                                            </ul>
                                            {{--                    {!!  $orders->links() !!}--}}
                                        </div>
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>

                </div>
            </div>
            <!-- end info box -->
        </div>

    </div>
@endsection

<style>
    td {
        vertical-align: middle !important;
    }

    .datefilter {
        border: 1px solid lightgrey;
        border-radius: 2px;
        padding-left: 10px;
    }

    .datefilter:focus-visible {
        outline: none !important;
    }

    .custom-menu {
        box-shadow: 0px 6px 10px lightgrey;
        z-index: 999999;
        top: 36px;
        left: 0;
        background: white;
        padding: 12px;
        min-width: 208px;
        border: 1px solid lightgrey;
    }

    .custom-span {
        position: absolute;
        right: 8px;
        top: 12px;
    }
</style>
{{--    datepicker js--}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script src="{{asset('custom_assets/js/app_custom.js')}}"></script>

@section('script')
    <script>
        function openCity(evt, cityName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
        }
    </script>
    <script>
        $(document).ready(function () {
            // $(document).on('click', '.main-tr', function () {
            //     window.location.href = $(this).data('href');
            // });

            $(document).click(function (event) {

                var $trigger = $(".position-relative-2");

                if ($trigger !== event.target && !($trigger.has(event.target).length)) {

                    $('.custom-menu').addClass('d-none');
                }
            });

            $('.result-per-page').click(function (event) {
                if ($(this).next().hasClass('d-none')) {
                    $('.custom-menu').addClass('d-none');
                    $(this).next().removeClass('d-none');
                } else {
                    $(this).next().addClass('d-none');
                }
            });
            $(document).on('mouse', function (event) {
                if ($(this).next().hasClass('d-none')) {
                    $('.custom-menu').addClass('d-none');
                    $(this).next().removeClass('d-none');
                } else {
                    $(this).next().addClass('d-none');
                }
            });

            $('.fulfillment-status').click(function (event) {
                if ($(this).next().hasClass('d-none')) {
                    $('.custom-menu').addClass('d-none');
                    $(this).next().removeClass('d-none');
                } else {
                    $(this).next().addClass('d-none');
                }
            });

            $('.alert-status').click(function (event) {
                if ($(this).next().hasClass('d-none')) {
                    $('.custom-menu').addClass('d-none');
                    $(this).next().removeClass('d-none');
                } else {
                    $(this).next().addClass('d-none');
                }
            });
            $('.lookups_range').click(function (event) {
                if ($(this).next().hasClass('d-none')) {
                    $('.custom-menu').addClass('d-none');
                    $(this).next().removeClass('d-none');
                } else {
                    $(this).next().addClass('d-none');
                }
            });

            $('input[name="datefilter"]').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                }
            });

            $('input[name="datefilter"]').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
            });

            $('input[name="datefilter"]').on('cancel.daterangepicker', function (ev, picker) {
                $(this).val('');
            });

        });
    </script>
@endsection
