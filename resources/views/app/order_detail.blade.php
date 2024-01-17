@extends('app.layout.default')
<style>
    .resource-list__header {
        background: white !important;
        border: 0 !important;
        padding-top: 20px !important;
        border-radius: 15px !important;
    }

    .custom-p {
        margin-bottom: 0px !important;
    }

    .tracking-detail {
        padding: 3rem 0
    }

    hr {
        margin: 0 12px !important;
    }

    #tracking {
        margin-bottom: 1rem
    }

    [class*=tracking-status-] p {
        margin: 0;
        font-size: 1.1rem;
        color: #fff;
        text-transform: uppercase;
        text-align: center
    }

    [class*=tracking-status-] {
        padding: 1.6rem 0
    }

    .tracking-status-intransit {
        background-color: #65aee0
    }

    .tracking-status-outfordelivery {
        background-color: #f5a551
    }

    .tracking-status-deliveryoffice {
        background-color: #f7dc6f
    }

    .tracking-status-delivered {
        background-color: #4cbb87
    }

    .tracking-status-attemptfail {
        background-color: #b789c7
    }

    .tracking-status-error, .tracking-status-exception {
        background-color: #d26759
    }

    .tracking-status-expired {
        background-color: #616e7d
    }

    .tracking-status-pending {
        background-color: #ccc
    }

    .tracking-status-inforeceived {
        background-color: #214977
    }

    /* .tracking-list {
     border:1px solid #e5e5e5
    } */
    .tracking-item {
        border-left: 1px solid #e5e5e5;
        position: relative;
        padding: 2rem 1.5rem .5rem 2.5rem;
        font-size: .9rem;
        margin-left: 3rem;
        min-height: 5rem
    }

    .tracking-item:last-child {
        padding-bottom: 4rem
    }

    .tracking-item .tracking-date {
        margin-bottom: .5rem
    }

    .tracking-item .tracking-date span {
        color: #888;
        font-size: 85%;
        padding-left: .4rem
    }

    .tracking-item .tracking-content {
        padding: 0;
        /*background-color: #f4f4f4;*/
        border-radius: .5rem
    }

    .tracking-item .tracking-content span {
        display: block;
        color: #888;
        font-size: 85%
    }

    .tracking-item .tracking-icon {
        line-height: 2.6rem;
        position: absolute;
        left: -9px;
        width: 1.6rem;
        top: 43px;
        height: 1.6rem;
        text-align: center;
        border-radius: 50%;
        font-size: 1.1rem;
        background-color: #fff;
        color: #fff;
    }

    .tracking-item .tracking-icon.status-sponsored {
        background-color: #f68
    }

    .tracking-item .tracking-icon.status-delivered {
        background-color: #4cbb87
    }

    .tracking-item .tracking-icon.status-outfordelivery {
        background-color: #f5a551
    }

    .tracking-item .tracking-icon.status-deliveryoffice {
        background-color: #f7dc6f
    }

    .tracking-item .tracking-icon.status-attemptfail {
        background-color: #b789c7
    }

    .tracking-item .tracking-icon.status-exception {
        background-color: #d26759
    }

    .tracking-item .tracking-icon.status-inforeceived {
        background-color: #214977
    }

    .tracking-item .tracking-icon.status-intransit {
        /*color: #e5e5e5;*/
        border: 1px solid #e5e5e5;
        background-color: #5C6AC4 !important;
        font-size: .6rem
    }

    @media (min-width: 992px) {
        .tracking-item {
            margin-left: 2rem;
        }

        .tracking-item .tracking-date {
            position: absolute;
            left: -10rem;
            width: 7.5rem;
            text-align: right
        }

        .tracking-item .tracking-date span {
            display: block
        }

        .tracking-item .tracking-content {
            padding: 0;
            background-color: transparent
        }
    }
</style>
<style>
    svg {
        display: none;
    }

    /* The Modal (background) */
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 128px;
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0, 0, 0); /* Fallback color */
        background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
    }

    /* Modal Content */
    .modal-content {
        padding-top: 0 !important;
        background-color: #fefefe;
        margin: auto;
        padding: 20px;
        border: 1px solid #888;
        width: 55%;
    }

    /* The Close Button */
    .close {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }

    /* Style the tab */
    .tab {
        /*margin-top: 55px;*/
        overflow: hidden;
        /*border: 1px solid #ccc;*/
        /*background-color: #f1f1f1;*/
    }

    /* Style the buttons inside the tab */
    .tab button {
        border-bottom: 3px solid white !important;
        background-color: inherit;
        float: left;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 14px 16px;
        transition: 0.3s;
        font-size: 17px;
    }

    /* Change background color of buttons on hover */
    .tab button:hover {
        background-color: #ddd;
    }

    /* Create an active/current tablink class */
    .tab button.active {
        border-bottom: 3px solid #5c6ac4 !important;
        outline: none !important;
    }

    /* Style the tab content */
    .tabcontent {
        display: none;
        padding: 6px 12px;
        /*border: 1px solid #ccc;*/
        border-top: none;
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
</style>
@section('content')
    <div class="container" style="min-height: 510px;">
        @php
            $total_items = 0;
        @endphp

        {{--            order header start--}}
        <div class="row pt-4 mx-1">
            <div class="col-md-12 card  ">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="d-flex custom-top-div align-items-center">
                                <div class=" ">
                                    <a style="text-decoration: none; color: black;" href="{{URL::tokenRoute('home')}}">
                                        <ul class="pagination mb-0">
                                            <li class="page-item">
                                                <a class="btn" href="{{URL::tokenRoute('home')}}">
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
                                        </ul>
                                    </a>
                                </div>
                                <div>
                                    <h4 class="display-4 ml-3 mr-2">{{$order_data->name}}</h4>
                                </div>
                                @if($order_data->financial_status == "paid")
                                    <div><span class="badge badge--success ">Paid</span></div>
                                @elseif($order_data->financial_status == 'partially paid')
                                    <div><span class="badge badge--attention">Partially Paid</span>
                                    </div>
                                @elseif($order_data->financial_status == 'pending')
                                    <div><span class="badge badge--warning  ">Pending</span></div>
                                @elseif($order_data->financial_status == 'authorized')
                                    <div><span class="badge badge--info ">Authorized</span></div>
                                @else
                                    <div><span
                                            class="badge ">{{$order_data->financial_status}}</span>
                                    </div>
                                @endif

                                @if($order_data->fulfillment_status == null)
                                    <div><span class="badge badge--warning">Unfulfilled</span></div>
                                @elseif($order_data->fulfillment_status == 'partial')
                                    <div><span class="badge badge--attention">Partial Fulfilled</span>
                                    </div>
                                @elseif($order_data->fulfillment_status == 'fulfilled')
                                    <div><span class="badge badge--success">Fulfilled</span></div>
                                @endif

                            </div>
                            <div class="ml-5 " style="padding-left: 28px !important;">
                                <div>
                                    <p style="margin-bottom: 0 !important;">{{ \Carbon\Carbon::parse($order_data->created_at)->format('F d, Y ')}}
                                        at {{ \Carbon\Carbon::parse($order_data->created_at)->format('g:i A')}} from
                                        Online
                                        Store</p></div>
                            </div>
                        </div>

                        @if($order_data->financial_status == "paid" && isset($order_data->deliver_method ) && $order_data->deliver_method == "Local Pickup")
                            <div class="btn-group">
                                <div>
                                    <a class="btn btn-primary btn-sm"
                                       href="{{URL::tokenRoute('email.order.pickup',['status'=>'manual','shopify_order_id'=>$order_data->shopify_order_id,'user_id'=>\Illuminate\Support\Facades\Auth::user()->id])}}">Ready For Pickup</a>
                                </div>
                                <div>
                                    <a class="btn btn-primary btn-sm"
                                       href="{{URL::tokenRoute('email.order.fulfillment',['status'=>'manual','shopify_order_id'=>$order_data->shopify_order_id,'user_id'=>\Illuminate\Support\Facades\Auth::user()->id])}}">Mark As Picked Up</a>
                                </div>
                                <div>
                                    <a class="btn btn-primary btn-sm"
                                       href="{{URL::tokenRoute('send.manual.email',[$order_data->shopify_order_id])}}">Send Email</a>
                                </div>
                            </div>

                        @endif
                    </div>

                </div>
            </div>
        </div>
        {{--            order header end--}}
        <div class="row">
            <section class="col-md-8 col-sm-12 mb-4">
                {{--        order fulfill null start--}}
                @if(($order_data->fulfillment_status == null))
                    <div class="card ">
                        <div class="card-body">
                            <div><h5>Unfulfilled</h5></div>
                            @foreach(json_decode($order_data->line_items) as $key=>$line_item)
                                @if($line_item->fulfillment_status == null)
                                    <input hidden value="{{$line_item->id}}" name="line_items[]">
                                    <div class="custom align-items-center" style="">
                                        <div class="mr-3 custom-div-child1">
                                            {{--                                        @dd($line_item->image)--}}
                                            @if(isset($line_item->image))
                                                <img style="padding: 2px;" src="{{$line_item->image}}" width="50px"
                                                     height="50px"
                                                     alt="product-image">
                                            @else
                                                <img style="padding: 2px;"
                                                     src="{{asset('custom_assets\images\random_product.jpg')}}"
                                                     width="50px" height="50px" alt="product-image">
                                            @endif
                                        </div>
                                        <div style="position: relative;" class="mr-3 custom-div-child2">
                                            <p class="mb-0">{{ucwords($line_item->title)}}</p>
                                            @if(isset($line_item->variant_title) && $line_item->variant_title != "")<p class="mb-0 mt-0" >{{isset($line_item->variant_title)?$line_item->variant_title:null}}</p>@endif
                                            @if(isset($line_item->sku) && $line_item->sku != "")<p class="mb-0 mt-0">{{isset($line_item->sku)?"SKU: ".$line_item->sku:null}}</p>@endif

                                        </div>
                                        <div class="mx-2 custom-div-child3">
                                            <p>{{$order_data->currency." "}}{{number_format($line_item->price,2)}}
                                                × {{$line_item->quantity}}</p>
                                        </div>
                                        <div class="ml-3 custom-div-child4">
                                            <p>{{$order_data->currency." "}}{{number_format($line_item->price * $line_item->quantity,2)}}</p>
                                        </div>
                                    </div>
                                    @php
                                        $total_items = 0;
                                        foreach(json_decode($order_data->line_items) as $line_item)
                                        {
                                            $total_items = $line_item->quantity + $total_items;
                                        }
                                    @endphp
                                @endif
                            @endforeach
                            {{--                                <div class="text-right">--}}
                            {{--                                    <button type="submit" class="btn btn-primary text-white">Fulfill Items</button>--}}
                            {{--                                </div>--}}
                        </div>


                    </div>
                    {{--            order fulfill null end--}}

                    {{--            order fulfill status fulfilled start --}}
                @elseif(($order_data->fulfillment_status == 'fulfilled'))
                    <div class="card  ">
                        <div class="card-body">

                            <h5>Fulfilled</h5>

                            {{--                                This Line Items Have Tracking Information --}}
                            @if($order_data->fulfillments()->where('tracking_number','!=',null)->where('tracking_company','!=',null)->count())
                                @php $order_fulfillments = $order_data->fulfillments()->where('tracking_number','!=',null)->where('tracking_company','!=',null)->get(); @endphp
                                @foreach($order_fulfillments as $fulfilments)
                                    @if($fulfilments != null && $fulfilments->tracking_number != null  && $fulfilments->tracking_company != null)
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="mx-2 my-3">
                                                <p class="my-0">{{strtoupper($fulfilments->tracking_company_mapping)}}</p>
                                                {{--                                                @if(isset($plans_status) && $plans_status == 'active')--}}
                                                <p class="my-0"><a
                                                        @if(isset($fulfilments->tracking_url)) target="_blank" @endif
                                                    href="{{$fulfilments->tracking_url}}">{{$fulfilments->tracking_number}}
                                                        <i class="fas fa-external-link-alt"></i></a>
                                                </p>
                                                {{--                                                @endif--}}
                                            </div>
                                        </div>
                                    @endif
                                    @php
                                        $line_items = json_decode($fulfilments->line_items);
                                    @endphp
                                    @foreach($line_items as $key=>$line_item)
                                        <div class="custom align-items-center" style="">
                                            <div class="mr-3 custom-div-child1">
                                                {{--                                        @dd($line_item->image)--}}
                                                @php
                                                    $order = \App\Models\Order::where('shopify_order_id',$fulfilments->order_id)->first();
                                                @endphp
                                                <img style="padding: 2px;"
                                                     src="@foreach (json_decode($order->line_items) as $order_line_item )
                                                     @if($order_line_item->id == $line_item->id)
                                                     {{$order_line_item->image}}
                                                     @endif
                                                     @endforeach"
                                                     width="50px" height="50px" alt="product-image">
                                                {{--                                                        @else--}}
                                                {{--                                                            <img src="{{asset('custom_assets\images\random_product.jpg')}}" width="50px" height="50px" alt="product-image">--}}
                                                {{--                                                        @endif--}}
                                            </div>
                                            <div style="position: relative;" class="mr-3 custom-div-child2">
                                                <p class="mb-0">{{ucwords($line_item->title)}}</p>
                                                @if(isset($line_item->variant_title) && $line_item->variant_title != "")<p class="mb-0 mt-0" >{{isset($line_item->variant_title)?$line_item->variant_title:null}}</p>@endif
                                                @if(isset($line_item->sku) && $line_item->sku != "")<p class="mb-0 mt-0">{{isset($line_item->sku)?"SKU: ".$line_item->sku:null}}</p>@endif

                                            </div>
                                            <div class="mx-2 custom-div-child3">
                                                <p>{{$order_data->currency." "}}{{number_format($line_item->price,2)}}
                                                    × {{$line_item->quantity}}</p>
                                            </div>
                                            <div class="ml-3 custom-div-child4">
                                                <p>{{$order_data->currency." "}}{{number_format($line_item->price * $line_item->quantity,2)}}</p>
                                            </div>
                                        </div>

                                        @php
                                            $total_items = 0;
                                            foreach(json_decode($order_data->line_items) as $line_item)
                                            {
                                                $total_items = $line_item->quantity + $total_items;
                                            }
                                        @endphp
                                        @if(isset($line_items) && count($line_items)-1 == $key)  @else
                                            <hr> @endif
                                    @endforeach

                                @endforeach
                            @elseif($order_data->fulfillments()->where('tracking_number',null)->where('tracking_url',null)->count())

                            @else

                            @endif
                            {{--                                This Line Items Have Tracking Information --}}
                            @if($order_data->fulfillments()->where('tracking_number',null)->where('tracking_url',null)->count())
                                @php
                                    $order_fulfillments = $order_data->fulfillments()->where('tracking_number',null)->where('tracking_url',null)->get();
                                @endphp
                                @foreach($order_fulfillments as $order_fulfillment)
                                    @foreach(json_decode($order_fulfillment->line_items) as $line_item )
                                        <div class="custom align-items-center" style="">
                                            <div class="mr-3 custom-div-child1">
                                                @php
                                                    $order = \App\Models\Order::where('shopify_order_id',$order_fulfillment->order_id)->first();
                                                @endphp
                                                <img style="padding: 2px;"
                                                     src="@foreach (json_decode($order->line_items) as $order_line_item )
                                                     @if($order_line_item->id == $line_item->id)
                                                     {{$order_line_item->image}}
                                                     @endif
                                                     @endforeach"
                                                     width="50px" height="50px" alt="product-image">
                                            </div>
                                            <div style="position: relative;" class="mr-3 custom-div-child2">
                                                <p class="mb-0">{{ucwords($line_item->title)}}</p>
                                                @if(isset($line_item->variant_title) && $line_item->variant_title != "")<p class="mb-0 mt-0" >{{isset($line_item->variant_title)?$line_item->variant_title:null}}</p>@endif
                                                @if(isset($line_item->sku) && $line_item->sku != "")<p class="mb-0 mt-0">{{isset($line_item->sku)?"SKU: ".$line_item->sku:null}}</p>@endif

                                            </div>
                                            <div class="mx-2 custom-div-child3">
                                                <p>{{$order_data->currency." "}}{{number_format($line_item->price,2)}}
                                                    × {{$line_item->quantity}}</p>
                                            </div>
                                            <div class="ml-3 custom-div-child4">
                                                <p>{{$order_data->currency." "}}{{number_format($line_item->price * $line_item->quantity,2)}}</p>
                                            </div>
                                        </div>


                                        @php
                                            $total_items = 0;
                                            foreach(json_decode($order_data->line_items) as $line_item)
                                            {
                                                $total_items = $line_item->quantity + $total_items;
                                            }
                                        @endphp
                                    @endforeach
                                @endforeach
                            @endif
                        </div>
                    </div>
                    {{--            order fulfill status fulfilled end--}}

                    {{--            order fulfill status partial start--}}
                @elseif($order_data->fulfillment_status == 'partial')
                    <div class="card  ">
                        <div class="card-body">
                            @php
                                $count = 1;
                            @endphp
                            @foreach(json_decode($order_data->line_items) as $key=>$line_item)
                                {{--    Lineitem Fulfill Status Null    --}}
                                @if($line_item->fulfillment_status == null)
                                    @if($count == 1)
                                        <div><h5>Unfulfilled</h5></div>
                                        @php $count++; @endphp
                                    @endif
                                    <div class="custom align-items-center" style="">
                                        <div class="mr-3 custom-div-child1">
                                            {{--                                        @dd($line_item->image)--}}
                                            @if(isset($line_item->image))
                                                <img style="padding: 2px;" src="{{$line_item->image}}" width="50px"
                                                     height="50px"
                                                     alt="product-image">
                                            @else
                                                <img style="padding: 2px;"
                                                     src="{{asset('custom_assets\images\random_product.jpg')}}"
                                                     width="50px" height="50px" alt="product-image">
                                            @endif
                                        </div>
                                        <div style="position: relative;" class="mr-3 custom-div-child2">
                                            <p class="mb-0">{{ucwords($line_item->title)}}</p>
                                            @if(isset($line_item->variant_title) && $line_item->variant_title != "")<p class="mb-0 mt-0" >{{isset($line_item->variant_title)?$line_item->variant_title:null}}</p><br>@endif
                                            @if(isset($line_item->sku) && $line_item->sku != "")<p class="mb-0 mt-0">{{isset($line_item->sku)?"SKU: ".$line_item->sku:null}}</p><br>@endif

                                        </div>
                                        <div class="mx-2 custom-div-child3">
                                            <p>{{$order_data->currency." "}}{{number_format($line_item->price,2)}}
                                                × {{$line_item->quantity}}</p>
                                        </div>
                                        <div class="ml-3 custom-div-child4">
                                            <p>{{$order_data->currency." "}}{{number_format($line_item->price * $line_item->quantity,2)}}</p>
                                        </div>
                                    </div>
                                    @php
                                        $total_items = 0;
                                        foreach(json_decode($order_data->line_items) as $line_item)
                                        {
                                            $total_items = $line_item->quantity + $total_items;
                                        }
                                    @endphp
                                @elseif($line_item->fulfillment_status == 'partial')
                                    @if($count == 1)
                                        <div><h5>Unfulfilled</h5></div>
                                        @php $count++; @endphp
                                    @endif
                                    <div class="custom align-items-center" style="">
                                        <div class="mr-3 custom-div-child1">
                                            {{--                                        @dd($line_item->image)--}}
                                            @if(isset($line_item->image))
                                                <img style="padding: 2px;" src="{{$line_item->image}}" width="50px"
                                                     height="50px"
                                                     alt="product-image">
                                            @else
                                                <img style="padding: 2px;"
                                                     src="{{asset('custom_assets\images\random_product.jpg')}}"
                                                     width="50px" height="50px" alt="product-image">
                                            @endif
                                        </div>
                                        <div style="position: relative;" class="mr-3 custom-div-child2">
                                            <p class="mb-0">{{ucwords($line_item->title)}}</p>
                                            @if(isset($line_item->variant_title) && $line_item->variant_title != "")<p class="mb-0 mt-0" >{{isset($line_item->variant_title)?$line_item->variant_title:null}}</p>@endif
                                            @if(isset($line_item->sku) && $line_item->sku != "")<p class="mb-0 mt-0">{{isset($line_item->sku)?"SKU: ".$line_item->sku:null}}</p>@endif

                                        </div>
                                        <div class="mx-2 custom-div-child3">
                                            <p>{{$order_data->currency." "}}{{number_format($line_item->price,2)}}
                                                × {{$line_item->fulfillable_quantity}}</p>
                                        </div>
                                        <div class="ml-3 custom-div-child4">
                                            <p>{{$order_data->currency." "}}{{number_format($line_item->price * $line_item->fulfillable_quantity,2)}}</p>
                                        </div>
                                    </div>
                                    @php
                                        $total_items = 0;
                                        foreach(json_decode($order_data->line_items) as $line_item)
                                        {
                                            $total_items = $line_item->quantity + $total_items;
                                        }
                                    @endphp
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="card my-3 ">
                        <div class="card-body">
                            @php
                                $count2 = 1;
                            @endphp

                            <h5>Fulfilled</h5>
                            @if($order_data->fulfillments()->where('tracking_number','!=',null)->where('tracking_company','!=',null)->count())
                                @php $order_fulfillments = $order_data->fulfillments()->where('tracking_number','!=',null)->where('tracking_company','!=',null)->get(); @endphp
                                @foreach($order_fulfillments as $fulfilments)
                                    @if($fulfilments != null && $fulfilments->tracking_number != null  && $fulfilments->tracking_company != null)
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="mx-2 my-3">
                                                <p class="my-0">{{strtoupper($fulfilments->tracking_company_mapping)}}</p>
                                                {{--                                                @if(isset($plans_status) && $plans_status == 'active')--}}
                                                <p class="my-0"><a
                                                        @if(isset($fulfilments->tracking_url)) target="_blank" @endif
                                                    href="{{$fulfilments->tracking_url}}">{{$fulfilments->tracking_number}}
                                                        <i class="fas fa-external-link-alt"></i></a>
                                                </p>
                                                {{--                                                @endif--}}
                                            </div>
                                        </div>
                                    @endif
                                    @php
                                        $line_items = json_decode($fulfilments->line_items);
                                    @endphp
                                    @foreach($line_items as $key=>$line_item)
                                        <div class="custom align-items-center" style="">
                                            <div class="mr-3 custom-div-child1">
                                                {{--                                        @dd($line_item->image)--}}
                                                @php
                                                    $order = \App\Models\Order::where('shopify_order_id',$fulfilments->order_id)->first();
                                                @endphp
                                                <img style="padding: 2px;"
                                                     src="@foreach (json_decode($order->line_items) as $order_line_item )
                                                     @if($order_line_item->id == $line_item->id)
                                                     {{$order_line_item->image}}
                                                     @endif
                                                     @endforeach"
                                                     width="50px" height="50px" alt="product-image">
                                                {{--                                                        @else--}}
                                                {{--                                                            <img src="{{asset('custom_assets\images\random_product.jpg')}}" width="50px" height="50px" alt="product-image">--}}
                                                {{--                                                        @endif--}}
                                            </div>
                                            <div style="position: relative;" class="mr-3 custom-div-child2">
                                                <p class="mb-0">{{ucwords($line_item->title)}}</p>
                                                @if(isset($line_item->variant_title) && $line_item->variant_title != "")<p class="mb-0 mt-0" >{{isset($line_item->variant_title)?$line_item->variant_title:null}}</p><br>@endif
                                                @if(isset($line_item->sku) && $line_item->sku != "")<p class="mb-0 mt-0">{{isset($line_item->sku)?"SKU: ".$line_item->sku:null}}</p><br>@endif

                                            </div>
                                            <div class="mx-2 custom-div-child3">
                                                <p>{{$order_data->currency." "}}{{number_format($line_item->price,2)}}
                                                    × {{$line_item->quantity}}</p>
                                            </div>
                                            <div class="ml-3 custom-div-child4">
                                                <p>{{$order_data->currency." "}}{{number_format($line_item->price * $line_item->quantity,2)}}</p>
                                            </div>
                                        </div>
                                        @php
                                            $total_items = 0;
                                            foreach(json_decode($order_data->line_items) as $line_item)
                                            {
                                                $total_items = $line_item->quantity + $total_items;
                                            }
                                        @endphp
                                        @if(isset($line_items) && count($line_items)-1 == $key)  @else
                                            <hr> @endif
                                    @endforeach

                                @endforeach
                            @endif
                            {{--                                This Line Items Have Tracking Information --}}
                            @if($order_data->fulfillments()->where('tracking_number',null)->where('tracking_url',null)->count())
                                @php
                                    $order_fulfillments = $order_data->fulfillments()->where('tracking_number',null)->where('tracking_url',null)->get();
                                @endphp
                                @foreach($order_fulfillments as $order_fulfillment)
                                    @foreach(json_decode($order_fulfillment->line_items) as $line_item )
                                        <div class="custom align-items-center" style="">
                                            <div class="mr-3 custom-div-child1">
                                                @php
                                                    $order = \App\Models\Order::where('shopify_order_id',$order_fulfillment->order_id)->first();
                                                @endphp
                                                <img style="padding: 2px;"
                                                     src="@foreach (json_decode($order->line_items) as $order_line_item )
                                                     @if($order_line_item->id == $line_item->id)
                                                     {{$order_line_item->image}}
                                                     @endif
                                                     @endforeach"
                                                     width="50px" height="50px" alt="product-image">
                                            </div>
                                            <div style="position: relative;" class="mr-3 custom-div-child2">
                                                <p class="mb-0">{{ucwords($line_item->title)}}</p>
                                                @if(isset($line_item->variant_title) && $line_item->variant_title != "")<p class="mb-0 mt-0" >{{isset($line_item->variant_title)?$line_item->variant_title:null}}</p>@endif
                                                @if(isset($line_item->sku) && $line_item->sku != "")<p class="mb-0 mt-0">{{isset($line_item->sku)?"SKU: ".$line_item->sku:null}}</p>@endif

                                            </div>
                                            <div class="mx-2 custom-div-child3">
                                                <p>{{$order_data->currency." "}}{{number_format($line_item->price,2)}}
                                                    × {{$line_item->quantity}}</p>
                                            </div>
                                            <div class="ml-3 custom-div-child4">
                                                <p>{{$order_data->currency." "}}{{number_format($line_item->price * $line_item->quantity,2)}}</p>
                                            </div>
                                        </div>
                                        @php
                                            $total_items = 0;
                                            foreach(json_decode($order_data->line_items) as $line_item)
                                            {
                                                $total_items = $line_item->quantity + $total_items;
                                            }
                                        @endphp
                                    @endforeach
                                @endforeach
                            @endif
                        </div>
                    </div>
                @endif
                {{--        order fulfill partial end--}}

                {{--                    total price Card start--}}
                <div class="card  my-3">
                    <div class="card-body">
                        @if($order_data->financial_status == "paid")
                            <div><h5 class="">Paid</h5></div>
                        @elseif($order_data->financial_status == 'partially paid')
                            <div><h5 class="">Partially Paid</h5></div>
                        @elseif($order_data->financial_status == 'pending')
                            <div><h5 class="">Pending</h5></div>
                        @elseif($order_data->financial_status == 'authorized')
                            <div><h5 class="">Authorized</h5></div>
                        @else
                            <div><h5 class="">{{$order_data->financial_status}}</h5></div>
                        @endif

                        <div class="custom2" style="">
                            <div class="mr-3 card-child-div1">
                                <p>Subtotal</p>
                            </div>
                            <div style="  " class="mr-3 card-child-div2">
                                <p class="card-child-p" style="">{{$total_items}} item</p>
                            </div>
                            <div class="ml-3 w-25 text-right">
                                <p>{{$order_data->currency." "}}{{number_format($order_data->total_line_items_price,2)}}</p>
                            </div>
                        </div>
                        @if(json_decode($order_data->discount_codes) != null)
                            <div class="custom2" style="">
                                <div class="mr-3 card-child-div1">
                                    <p>Discount</p>
                                </div>
                                <div style="  " class="mr-3 card-child-div2">
                                    <p class="card-child-p" style="">
                                        @foreach(json_decode($order_data->discount_codes) as $discount_code)
                                            {{$discount_code->code}}
                                        @endforeach
                                    </p>
                                </div>
                                <div class="ml-3">

                                    <p>${{$order_data->total_discounts}}</p>
                                </div>
                            </div>
                        @endif
                        @if(json_decode($order_data->total_tax) != null)
                            <div class="custom2" style="">
                                <div class="mr-3 card-child-div1">
                                    <p>Tax</p>
                                </div>
                                <div class="mr-3 card-child-div2">
                                    <p class="card-child-p">
                                        @foreach(json_decode($order_data->tax_lines) as $tax_line)
                                            {{$tax_line->title}} {{$tax_line->rate*100}}%
                                        @endforeach
                                    </p>
                                </div>
                                <div class="ml-3">
                                    <p>
                                        @foreach(json_decode($order_data->tax_lines) as $tax_line)
                                            {{$order_data->currency." "}}{{number_format($tax_line->price,2)}}
                                        @endforeach
                                    </p>
                                </div>
                            </div>
                        @endif
                        <div class="custom2" style="">
                            <div class="mr-3 card-child-div1">
                                <h6>Total</h6>
                            </div>

                            <div class="ml-3 card-child-div2" style=" text-align: end;">
                                <h6>{{$order_data->currency." "}}{{number_format(json_decode($order_data->total_price),2)}}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white card2-footer-radius">
                        <div class="card2-footer-button">
                            <div style="margin-left: -22px;"><p>Paid by customer</p></div>
                            <div style="margin-right: -22px;">
                                <p>{{$order_data->currency." "}}{{number_format(json_decode($order_data->total_price),2)}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                {{--                    total price Card end--}}
                <div class="row " style="margin-bottom: 24px;">
                    <div class="col-md-12">
                        <section class="card">
                            <div class="card-header-actions">
                                <div>
                                    <div class="tab ">
                                        <button class="tablinks active" onclick="openCity(event,'email_logs')">
                                            Email Logs
                                        </button>
                                        {{--                                <button class="tablinks" onclick="openCity(event, 'email_history')">Email History</button>--}}
                                        {{--                                        <button class="tablinks" onclick="openCity(event,'visit_history')">Logs</button>--}}
                                    </div>

                                    <div id="email_logs" class="tabcontent"
                                         style="display:block;text-align: left;">
                                        <div class="tracking-list mb-3">
                                            @if($email_logs->count())
                                                @foreach($email_logs as $email_log)
                                                    <div class="tracking-item">
                                                        <div class="tracking-icon status-intransit"
                                                             style="background-color:#e5e5e5">
                                                        </div>
                                                        <div class="tracking-content"
                                                             style="font-size: 1.4rem;">
                                                            @if(isset($email_log->created_at) && $email_log->created_at != '')
                                                                <p class="custom-p">{{date_format(date_create($email_log->created_at),"l, M d, Y h:iA")}}</p>
                                                            @endif
                                                            @if(isset($email_log->status) && $email_log->status != '')
                                                                <p class="custom-p">{{ucwords($email_log->status)}}</p>
                                                            @endif
                                                            @if(isset($email_log->message) && $email_log->message != '')
                                                                <p class="custom-p">{{ucwords($email_log->message)}}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="main-table"
                                                     style="width:100%;     padding: 2% 3%!important;">
                                                    <div class="card-body">
                                                        <div class="empty-results">
                                                            <svg class="polaris-icon__svg" viewBox="0 0 20 20">
                                                                <path
                                                                    d="M8 12a4 4 0 1 1 0-8 4 4 0 0 1 0 8m9.707 4.293l-4.82-4.82A5.968 5.968 0 0 0 14 8 6 6 0 0 0 2 8a6 6 0 0 0 6 6 5.968 5.968 0 0 0 3.473-1.113l4.82 4.82a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414"
                                                                    fill-rule="evenodd"></path>
                                                            </svg>
                                                            <h2 class="empty-results__title">No email log
                                                                found</h2>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                        </div>
                                    </div>
                                    <div id="visit_history" class="tabcontent" style="text-align: left;">
                                        {{--                                            @if($order_data->tracking_stats->count())--}}
                                        {{--                                                @foreach($order_data->tracking_stats()->orderBy('created_at','desc')->get() as $tracking_stats)--}}
                                        {{--                                                    <div class="tracking-item">--}}
                                        {{--                                                        <div class="tracking-icon status-intransit" >--}}
                                        {{--                                                        </div>--}}
                                        {{--                                                        <!-- <div class="tracking-date">Aug 10, 2018<span>05:01 PM</span></div> -->--}}
                                        {{--                                                         </div>--}}
                                        {{--                                                        <div class="tracking-content" style="font-size: 1.4rem;">--}}
                                        {{--                                                            <p class="custom-p ">{{isset($tracking_stats->city)?$tracking_stats->city.", ":null}} {{isset($tracking_stats->state)?$tracking_stats->state:null}}</p>--}}
                                        {{--                                                            <p class="custom-p ">{{isset($tracking_stats->browser)?$tracking_stats->browser.', ':null}} {{isset($tracking_stats->device)?$tracking_stats->device.', ':null}} {{isset($tracking_stats->operating_system)?$tracking_stats->operating_system.'':null}}</p>--}}
                                        {{--                                                            <p class="custom-p ">{{isset($tracking_stats->ip_address)?$tracking_stats->ip_address:null}}</p>--}}
                                        {{--                                                            <p class="custom-p ">{{date_format(date_create($tracking_stats->created_at),"l, M d, Y H:i")}}</p>--}}
                                        {{--                                                                    <p class="custom-p">{{str_replace(',',', ',$trackinfo->Details)}}</p>--}}
                                        {{--                                                        </div>--}}
                                        {{--                                                    </div>--}}
                                        {{--                                                @endforeach--}}
                                        {{--                                            @else--}}
                                        <div class="main-table" style="width:100%;     padding: 2% 3%!important;">
                                            <div class="card-body">
                                                <div class="empty-results">
                                                    <svg class="polaris-icon__svg" viewBox="0 0 20 20">
                                                        <path
                                                            d="M8 12a4 4 0 1 1 0-8 4 4 0 0 1 0 8m9.707 4.293l-4.82-4.82A5.968 5.968 0 0 0 14 8 6 6 0 0 0 2 8a6 6 0 0 0 6 6 5.968 5.968 0 0 0 3.473-1.113l4.82 4.82a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414"
                                                            fill-rule="evenodd"></path>
                                                    </svg>
                                                    <h2 class="empty-results__title">No logs</h2>
                                                </div>
                                            </div>
                                        </div>
                                        {{--                                            @endif--}}

                                    </div>
                                </div>
                            </div>

                        </section>
                    </div>

                </div>
            </section>

            {{--      right card start      --}}
            <section class="col-md-4 col-sm-12 pl-0">
                {{--                    Secound Right Card--}}

                <div class="card  ">
                    <div class="resource-list__header ">
                        <h6 class="">Customer</h6>
                    </div>
                    <div class="card-custom-body">
                        <div class="">
                            <div>
                                <?php $customer = json_decode($order_data->customer);?>
                                @if(isset($customer->first_name)) {{$customer->first_name}} {{$customer->last_name}}
                                <br> @endif
                                @if(isset($customer->email)) {{$customer->email}} @else No email @endif <br>
                                @if(isset($customer->phone)) {{$customer->phone}} @elseif(isset($customer->default_address->phone)) {{$customer->default_address->phone}} @else
                                    No phone number @endif
                            </div>
                            {{--                            <div>--}}
                            {{--                                <p class="card-text">@if(isset($customer->orders_count)) {{$customer->orders_count}} order @endif</p>--}}
                            {{--                            </div>--}}
                        </div>
                    </div>

                    @if(isset($order_data->shipping_address) && json_decode($order_data->shipping_address) != null)
                        <hr>
                        <div class="resource-list__header ">
                            <h6 class="">Shipping Address</h6>
                        </div>
                        <?php
                        $shipping_address = json_decode($order_data->shipping_address);
                        ?>
                        <div class="card-custom-body2 ">
                            <div class="">
                                <div class="d-flex justify-content-between">
                                    <div style="width: 60%;">
                                        <p class="">@if(isset($shipping_address->first_name)){{$shipping_address->first_name}}@endif @if(isset($shipping_address->last_name)){{$shipping_address->last_name}}@endif
                                            <br>
                                            @if(isset($shipping_address->zip)){{$shipping_address->zip}}<br>@endif
                                            @if(isset($shipping_address->province)){{$shipping_address->province}}@endif @if(isset($shipping_address->city)){{$shipping_address->city}}@endif
                                            @if(isset($shipping_address->address1)){{$shipping_address->address1}}
                                            <br>@endif
                                            @if( isset($shipping_address->address2) && $shipping_address->address2 != ''){{$shipping_address->address2}}
                                            <br>@endif
                                            @if(isset($shipping_address->country)){{$shipping_address->country}}@endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if(isset($order_data->billing_address) && json_decode($order_data->billing_address) != null)
                        <hr>
                        <div class="resource-list__header ">
                            <h6 class="">Billing Address</h6>
                        </div>
                        <div class="card-custom-body2">
                            <div class="">
                                <div class="d-flex justify-content-between">
                                    <?php
                                    $billing_address = json_decode($order_data->billing_address);
                                    ?>
                                    <div>

                                    </div>
                                </div>
                                @if(isset($billing_address))
                                    <p class="">
                                        @if(isset($billing_address->first_name)){{$billing_address->first_name}}@endif @if(isset($billing_address->last_name)){{$billing_address->last_name}}@endif
                                        <br>
                                        @if(isset($billing_address->zip)){{$billing_address->zip}}@endif<br>
                                        @if(isset($billing_address->province)){{$billing_address->province}}@endif @if(isset($billing_address->city)){{$billing_address->city}}@endif
                                        <br> @if(isset($billing_address->address1)){{$billing_address->address1}}
                                        <br>@endif
                                        @if(isset($billing_address->address2) && $billing_address->address2 != ''){{$billing_address->address2}}
                                        <br>@endif
                                        @if(isset($billing_address->country)){{$billing_address->country}}@endif
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
                {{--                    End Secound Right Card--}}
            </section>

            {{--      right card end      --}}

        </div>


        @endsection
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
@endsection
