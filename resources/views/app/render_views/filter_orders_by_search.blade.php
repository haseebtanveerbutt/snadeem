<div class="card-body-section table-responsive-wrapper">
    <table class="table table-hover">
        <thead>
        <tr>
            {{--                    <th scope="col">--}}
            {{--                        <label for="checkAll" class="polaris-check">--}}
            {{--                            <input type="checkbox" name="checkAll" id="checkAll">--}}
            {{--                            <span><span class="sr-only">Select All</span></span>--}}
            {{--                        </label>--}}
            {{--                    </th>--}}
            <th scope="col" class="sort">
                <a href="#" class="btn btn-link-sort">Order</a>
            </th>
            <th scope="col" class="sort">
                <a href="#" class="btn btn-link-sort active">
                    Date
                    <svg class="polaris-icon__svg icon-right" viewBox="0 0 20 20">
                        <path d="M5 8l5 5 5-5z" fill-rule="evenodd"></path>
                    </svg>
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
                    <td>{{$order->name}}
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
                            <div><span
                                    class="badge badge--attention">Partial Fulfilled</span>
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
                <td class="text-center" colspan="9">
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
                        <a class="btn  @if($orders->previousPageUrl()) prev2 @else disabled @endif"
                           data-shopid="{{$user->id}}"
                           data-href="{{$orders->previousPageUrl()}}" href="javascript:void(0)">
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
                        <a class="btn  @if($orders->nextPageUrl()) next2 @else disabled @endif"
                           data-shopid="{{$user->id}}"
                           data-href="{{$orders->nextPageUrl()}}" href="javascript:void(0)">
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


