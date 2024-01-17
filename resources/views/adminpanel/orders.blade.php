@extends('adminpanel.layout.default')
<style>
    .arrow {
        border: solid black;
        border-width: 0 1px 1px 0;
        display: inline-block;
        padding: 3px;
    }

    td {
        vertical-align: middle !important;
    }

    .down {
        transform: rotate(45deg);
        -webkit-transform: rotate(45deg);
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
                        @if(isset($user_id))
                            @php
                                $shop_name = \App\Models\User::find($user_id);
                            @endphp
                            <h5 style="margin-bottom: 0 !important;">{{$shop_name->name}}</h5>
                        @else
                            <h5 style="margin-bottom: 0 !important;">Orders</h5>
                        @endif
                    </div>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        @if(isset($user_id))
                            <li class="nav-item">
                                <a class="nav-link active" id="wizard_question-tab" data-toggle="tab"
                                   href="#wizard_question" role="tab"
                                   aria-controls="wizard_question"
                                   aria-selected="true">Wizard Question</a>
                            </li>
                        @endif
                        @if(isset($user_id))
                            <li class="nav-item">
                                <a class="nav-link   @if(is_null($user_id)) active @endif" id="orders-tab"
                                   data-toggle="tab"
                                   href="#orders" role="tab"
                                   aria-controls="orders"
                                   aria-selected="false">Orders</a>
                            </li>
                        @endif
                        @if(isset($user_id))
                            <li class="nav-item">
                                <a class="nav-link" id="widget-settings-tab" data-toggle="tab" href="#widget_settings"
                                   role="tab"
                                   aria-controls="widget_settings"
                                   aria-selected="false">Widget Settings</a>
                            </li>
                        @endif
                        @if(isset($user_id))
                            <li class="nav-item">
                                <a class="nav-link" id="plan-history-tab" data-toggle="tab" href="#plan_history"
                                   role="tab"
                                   aria-controls="plan_history"
                                   aria-selected="false">Plans</a>
                            </li>
                        @endif
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        @if(isset($user_id))
                            <div class="tab-pane fade show active" id="wizard_question" role="tabpanel"
                                 aria-labelledby="wizard_question-tab">
                                <div class="card col-md-12">
                                    <div class="card-body col-md-12">

                                        @if($wizard->count())
                                            <div class="row">
                                                @foreach($wizard as $wiz)
                                                    @if($wiz->type == "Input Email" || $wiz->type == "Input Text")
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label style="font-weight: 500"
                                                                       for="#">{{$wiz->label}}</label>
                                                                <input type="text" disabled
                                                                       class="form-control  "
                                                                       value="{{isset($wiz->answer)?$wiz->answer:null}}">
                                                            </div>
                                                        </div>
                                                    @elseif($wiz->type == "Textarea")
                                                        <div class="col-md-12 mt-3">
                                                            <div class="form-group">
                                                                <label style="font-weight: 500"
                                                                       for="#">{{$wiz->label}}</label>
                                                                <textarea class="form-control" rows="4"
                                                                          disabled>@if(isset($wiz->answer)) {!! $wiz->answer !!} @endif</textarea>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-center">No Wizard Questions Found</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="tab-pane fade show @if(is_null($user_id)) active @endif " id="orders"
                             role="tabpanel"
                             aria-labelledby="orders-tab">
                            <div class="card order_render_div" style="border:0 !important;">
                                <div class="card-header-actions">
                                    <ul class="card-header-tabs">
                                        <li class="card-header-tab">
                                            <a class="  active all" data-filtertype="all" href="javascript:void(0)"
                                               data-shopid="{{isset($user_id)?$user_id:'admin'}}">All</a>
                                        </li>
                                        <li class="card-header-tab">
                                            <a href="javascript:void(0)"
                                               class="@if(isset($selected_filter) && $selected_filter =="unfulfilled") active @endif unfulfilled"
                                               data-filtertype="unfulfilled"
                                               data-shopid="{{isset($user_id)?$user_id:'admin'}}">Unfulfilled</a>
                                        </li>
                                        <li class="card-header-tab">
                                            <a href="javascript:void(0)"
                                               class="@if(isset($selected_filter) && $selected_filter =="partial") active @endif partial"
                                               data-filtertype="partial"
                                               data-shopid="{{isset($user_id)?$user_id:'admin'}}">Partial</a>
                                        </li>
                                        <li class="card-header-tab">
                                            <a href="javascript:void(0)"
                                               class="@if(isset($selected_filter) && $selected_filter =="paid") active @endif paid"
                                               data-filtertype="paid"
                                               data-shopid="{{isset($user_id)?$user_id:'admin'}}">Paid</a>
                                        </li>
                                        <li class="card-header-tab">
                                            <a href="javascript:void(0)"
                                               class="@if(isset($selected_filter) && $selected_filter =="unpaid") active @endif unpaid"
                                               data-filtertype="unpaid"
                                               data-shopid="{{isset($user_id)?$user_id:'admin'}}">Unpaid</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="row no-margins card-body-section">
                                        <div class="col-12">
                                            <input name="search" class="form-control filter-order-by-search"
                                                   data-href="{{route('admin.filter.search.orders',isset($user_id)?$user_id:'admin')}}"
                                                   placeholder="Filter Orders e.g #1001">
                                        </div>
                                    </div>
                                    <div class="card-body-section table-responsive-wrapper">
                                        <table class="table table-hover">
                                            <thead>
                                            <tr>
                                                <th scope="col">
                                                    <label for="checkAll" class="polaris-check">
                                                        <input type="checkbox" name="checkAll" id="checkAll">
                                                        <span><span class="sr-only">Select All</span></span>
                                                    </label>
                                                </th>
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
                                                @if(is_null($user_id))
                                                    <th scope="col" class="sort">
                                                        <a href="#" class="btn btn-link-sort">Shop</a>
                                                    </th>
                                                @endif
                                                <th scope="col" class="sort">
                                                    <a href="#" class="btn btn-link-sort">Payment Status</a>
                                                </th>
                                                <th scope="col" class="sort">
                                                    <a href="#" class="btn btn-link-sort">Fulfillment Status</a>
                                                </th>
                                                <th scope="col" class="sort">
                                                    <a href="#" class="btn btn-link-sort">Items</a>
                                                </th>
                                                <th scope="col" class="sort">
                                                    <a href="#" class="btn btn-link-sort">Delivery Method</a>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if($orders->count())
                                                @foreach($orders as $order)
                                                    <tr class="td-text-center main-tr" style="cursor: pointer"
                                                        data-href="{{route('admin.order.detail',$order->id)}}">
                                                        <td>
                                                            <label for="check1" class="polaris-check">
                                                                <input type="checkbox" name="check1" id="check1">
                                                                <span><span class="sr-only">Select Item</span></span>
                                                            </label>
                                                        </td>
                                                        <td><a class="td-a"
                                                               href="{{Route('admin.order.detail',$order->id)}}">{{$order->name}}</a>
                                                        </td>
                                                        <td>{{date("M d, Y h:i A ", strtotime( $order->created_at))}}</td>
                                                        <td>
                                                            @php
                                                                $customer = null;
                                                                if(isset($order->customer)){
                                                                    $customer = json_decode($order->customer);
                                                                    $customer = $customer->first_name.' '.$customer->last_name;
                                                                }
                                                            @endphp
                                                            @if(isset($customer))
                                                                {{ucwords($customer)}}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <span>{{$order->currency}}</span> {{number_format($order->total_price,2)}}
                                                        </td>
                                                        @if(is_null($user_id))
                                                            @php
                                                                $user = \App\Models\User::find($order->user_id);
                                                            @endphp
                                                            <td>
                                                                @if(isset($user))
                                                                    <span
                                                                        class="badge  badge--success  ">{{$user->name}}</span>
                                                                @endif
                                                            </td>
                                                        @endif
                                                        @php
                                                            $shipment_status = null;
                                                            if(isset($order->financial_status)){
                                                                $financial_status = $order->payment_status_mut;
                                                            }
                                                        @endphp
                                                        <td>
                                                            @if(isset($financial_status))
                                                                <span
                                                                    class="badge {{isset($financial_status->background)?$financial_status->background:null}}  ">{{ucwords($financial_status->public_text)}}</span>
                                                            @else
                                                                <p class="">--</p>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($order->fulfillment_status == null)
                                                                <div><span
                                                                        class="badge badge--warning">Unfulfilled</span>
                                                                </div>
                                                            @elseif($order->fulfillment_status == 'partial')
                                                                <div><span
                                                                        class="badge badge--attention">Partial Fulfilled</span>
                                                                </div>
                                                            @elseif($order->fulfillment_status == 'fulfilled')
                                                                <div><span class="badge badge--success">Fulfilled</span>
                                                                </div>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($order->lineitems->count() == 1) 1
                                                            item @else {{$order->lineitems->count()}} items @endif
                                                        </td>
                                                        @php
                                                            $shipping = null;
                                                            if(isset($order->shipping_lines)){
                                                                $shipping_decode = json_decode($order->shipping_lines);
                                                                if(isset($shipping_decode[0]->code)){
                                                                    $shipping = $shipping_decode[0]->code;
                                                                }
                                                            }
                                                        @endphp
                                                        <td>{{isset($shipping)?$shipping:null}}</td>
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
                                                               href="{{$orders->previousPageUrl()}}">
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
                                                            <a class="btn  @if($orders->nextPageUrl()) @else disabled @endif"
                                                               href="{{$orders->nextPageUrl()}}">
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
                        @if(isset($user_id))
                            <div class="tab-pane fade show " id="widget_settings" role="tabpanel"
                                 aria-labelledby="widget_settings-tab">
                                <div class="card col-md-12">
                                    <div class="card-body col-md-12">
                                        @if(isset($setting))
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="#">Button & Header Background Color</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="text" disabled
                                                           class="form-control header_button_bg_color disabled"
                                                           name="header_button_bg_color"
                                                           value="{{isset($setting->header_button_bg_color)?$setting->header_button_bg_color:'#20494D'}}"
                                                           data-coloris>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="#">Launcher Text Color</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <input disabled type="text"
                                                           class="form-control header_button_text_color"
                                                           name="header_button_text_color disabled"
                                                           value="{{isset($setting->header_button_text_color)?$setting->header_button_text_color:'#ffffff'}}"
                                                           data-coloris>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="#">Widget Position</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <select disabled name="widget_position"
                                                            class="form-control disabled widget_position">
                                                        <option
                                                            @if(isset($setting->widget_position) && $setting->widget_position == "lower right") selected
                                                            @endif value="lower right">Lower Right
                                                        </option>
                                                        <option
                                                            @if(isset($setting->widget_position) && $setting->widget_position == "lower left") selected
                                                            @endif value="lower left">Lower Left
                                                        </option>
                                                        {{--                                                    <option @if(isset($setting->widget_position) && $setting->widget_position == "lower center") selected @endif value="lower center">Lower Center</option>--}}
                                                        <option
                                                            @if(isset($setting->widget_position) && $setting->widget_position == "upper left") selected
                                                            @endif value="upper left">Upper Left
                                                        </option>
                                                        <option
                                                            @if(isset($setting->widget_position) && $setting->widget_position == "upper right") selected
                                                            @endif value="upper right">Upper Right
                                                        </option>
                                                        {{--                                                    <option @if(isset($setting->widget_position) && $setting->widget_position == "upper center") selected @endif value="upper center">Upper Center</option>--}}
                                                        {{--                                                    <option @if(isset($setting->widget_position) && $setting->widget_position == "middle left") selected @endif value="middle left">Middle Left</option>--}}
                                                        {{--                                                    <option @if(isset($setting->widget_position) && $setting->widget_position == "middle right") selected @endif value="middle right">Middle Right</option>--}}
                                                        {{--                                                    <option @if(isset($setting->widget_position) && $setting->widget_position == "middle center") selected @endif value="middle center">Middle Center</option>--}}
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row d-none">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Contact Button Text</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <input disabled class="form-control disabled contact_button"
                                                           name="contact_button"
                                                           value="{{isset($setting->contact_button)?$setting->contact_button:'Contact us'}}">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Launcher Button Text</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <input disabled class="form-control disabled launcher_label"
                                                           name="launcher_label"
                                                           value="{{isset($setting->launcher_label)?$setting->launcher_label:'Need Help?'}}">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Form Title Text</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <input disabled class="form-control disabled contact_form_title"
                                                           name="contact_form_title"
                                                           value="{{isset($setting->contact_form_title)?$setting->contact_form_title:'Feedback'}}">
                                                </div>
                                            </div>
                                        @else
                                            <p class="text-center">No Widget Settings Found</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if(isset($user_id))
                            <div class="tab-pane fade show " id="plan_history" role="tabpanel"
                                 aria-labelledby="plan_history-tab">
                                <div class="card col-md-12">
                                    <div class="card-body col-md-12">
                                        @if(isset($charges))
                                            <table id="datatabled"
                                                   class="table table-borderless  table-hover  table-class ">
                                                <thead class="border-0 ">

                                                <tr class="th-tr table-tr text-center">
                                                    <th class="font-weight-bold ">Name</th>
                                                    <th class="font-weight-bold ">Status</th>
                                                    <th class="font-weight-bold ">Type</th>
                                                    <th class="font-weight-bold ">Price</th>
                                                    <th class="font-weight-bold ">Activated On</th>
                                                    <th class="font-weight-bold ">Next Billing On</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                {{--                                        @dd($users_data)--}}
                                                @foreach($charges as $key=>$charge)
                                                    @php
                                                        $plan = \Osiset\ShopifyApp\Storage\Models\Plan::find($charge->plan_id);
                                                    @endphp
                                                    @if(isset($plan))
                                                        <tr class="td-text-center">
                                                            <td>
                                                                {{$charge->name}}
                                                            </td>

                                                            <td>
                                                                {{ $charge->status }}
                                                            </td>
                                                            <td>
                                                                {{$charge->type}}
                                                            </td>
                                                            <td>
                                                                ${{number_format($charge->price,2)}}
                                                            </td>
                                                            <td>
                                                                {{str_replace(' 00:00:00','',$charge->activated_on)}}
                                                            </td>
                                                            <td>
                                                                @if($charge->status == "ACTIVE")
                                                                    @php
                                                                        $plan_expire_on = date('Y-m-d H:i:s', strtotime($charge->billing_on . ' +30 days'));
                                                                    @endphp
                                                                    <b style="color: red">{{str_replace(' 00:00:00','',$plan_expire_on)}}</b>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endif

                                                @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            <p class="text-center">No Plans Found</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
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
                    console.log(2)
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
