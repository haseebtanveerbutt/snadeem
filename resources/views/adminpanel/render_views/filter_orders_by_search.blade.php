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
                        @if($order->lineitems->count() == 1) 1 item @else {{$order->lineitems->count()}} items @endif
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
                        <a class="btn  @if($orders->previousPageUrl()) prev @else disabled @endif"
                           data-shopid="{{$shop_id}}"
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
                        <a class="btn  @if($orders->nextPageUrl()) next @else disabled @endif"
                           data-shopid="{{$shop_id}}"
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


