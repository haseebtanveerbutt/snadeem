<table class="row section" style="width: 100%; border-spacing: 0; border-collapse: collapse;">
    <tbody>
    <tr>
        <td class="section__cell"
            style="font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Roboto&quot;, &quot;Oxygen&quot;, &quot;Ubuntu&quot;, &quot;Cantarell&quot;, &quot;Fira Sans&quot;, &quot;Droid Sans&quot;, &quot;Helvetica Neue&quot;, sans-serif; ">
            <center>
                <table class="container"
                       style="width: 560px; text-align: left; border-spacing: 0; border-collapse: collapse; margin: 0 auto;">
                    <tbody>
                    <tr>
                        <td style="font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Roboto&quot;, &quot;Oxygen&quot;, &quot;Ubuntu&quot;, &quot;Cantarell&quot;, &quot;Fira Sans&quot;, &quot;Droid Sans&quot;, &quot;Helvetica Neue&quot;, sans-serif;">
                            <h3 style="font-weight: normal; font-size: 20px; margin: 0 0 25px;margin-bottom: 12px !important;">Customer
                                Information</h3>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table class="container"
                       style="width: 560px; text-align: left; border-spacing: 0; border-collapse: collapse; margin: 0 auto;">
                    <tbody>
                    <tr>
                        <td style="font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Roboto&quot;, &quot;Oxygen&quot;, &quot;Ubuntu&quot;, &quot;Cantarell&quot;, &quot;Fira Sans&quot;, &quot;Droid Sans&quot;, &quot;Helvetica Neue&quot;, sans-serif;">

                            <table class="row" style="width: 100%; border-spacing: 0; border-collapse: collapse;">
                                <tbody>
                                <tr>
                                    <?php $customer = json_decode($order->customer);?>
                                    @if(isset($order->shipping_address) && json_decode($order->shipping_address) != null)
                                        <?php
                                        $shipping_address = json_decode($order->shipping_address);
                                        ?>
                                        @if(isset($shipping_address))
                                            <td class="customer-info__item"
                                                style="font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Roboto&quot;, &quot;Oxygen&quot;, &quot;Ubuntu&quot;, &quot;Cantarell&quot;, &quot;Fira Sans&quot;, &quot;Droid Sans&quot;, &quot;Helvetica Neue&quot;, sans-serif;  width: 50%;">
                                                <h4 style="font-weight: 500; font-size: 16px; color: #555; margin: 0 0 5px;">
                                                    Shipping address</h4>
                                                <p style="color: #777; line-height: 150%; font-size: 16px; margin: 0;"> @if(isset($shipping_address->first_name)){{$shipping_address->first_name}}@endif @if(isset($shipping_address->last_name)){{$shipping_address->last_name}}@endif
                                                    <br>
                                                    @if(isset($shipping_address->company) && $shipping_address->company != ""){{$shipping_address->company}}
                                                    <br>@endif
                                                    @if(isset($shipping_address->address1) && $shipping_address->address1 != ""){{$shipping_address->address1}}
                                                    <br>@endif
                                                    @if( isset($shipping_address->address2) && $shipping_address->address2 != ""){{$shipping_address->address2}}
                                                    <br>@endif
                                                    @if(isset($shipping_address->province)){{$shipping_address->province}}@endif @if(isset($shipping_address->city)) {{$shipping_address->city}}@endif
                                                    @if(isset($shipping_address->zip))<br>{{$shipping_address->zip}}
                                                    <br>@endif
                                                    @if(isset($shipping_address->country)){{$shipping_address->country}}
                                                    <br>@endif
                                                    @if(isset($shipping_address->phone)){{$shipping_address->phone}}
                                                    <br>@endif
                                                    @if(isset($customer->email)) {{$customer->email}} @endif
                                                </p>
                                            </td>
                                        @endif
                                    @endif
                                    @if(isset($order->billing_address) && json_decode($order->billing_address) != null)
                                        <?php
                                        $billing_address = json_decode($order->billing_address);
                                        ?>
                                        @if(isset($billing_address))
                                            <td class="customer-info__item"
                                                style="font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Roboto&quot;, &quot;Oxygen&quot;, &quot;Ubuntu&quot;, &quot;Cantarell&quot;, &quot;Fira Sans&quot;, &quot;Droid Sans&quot;, &quot;Helvetica Neue&quot;, sans-serif; width: 50%;">
                                                <h4 style="font-weight: 500; font-size: 16px; color: #555; margin: 0 0 5px;">
                                                    Billing address</h4>
                                                <p style="color: #777; line-height: 150%; font-size: 16px; margin: 0;">
                                                    @if(isset($billing_address->first_name)){{$billing_address->first_name}}@endif @if(isset($billing_address->last_name)){{$billing_address->last_name}} @endif
                                                    <br>
                                                    @if(isset($billing_address->company)  && $billing_address->company != ""){{$billing_address->company}}
                                                    <br> @endif
                                                    @if(isset($billing_address->address1) && $billing_address->address1 != ""){{$billing_address->address1}}
                                                    <br>@endif
                                                    @if(isset($billing_address->address2) && $billing_address->address2 != ''){{$billing_address->address2}}
                                                    <br>@endif
                                                    @if(isset($billing_address->province)){{$billing_address->province}}@endif @if(isset($billing_address->city)) {{$billing_address->city}}@endif
                                                    @if(isset($billing_address->zip))<br>{{$billing_address->zip}}
                                                    <br>@endif
                                                    @if(isset($billing_address->country)){{$billing_address->country}}
                                                    <br>@endif
                                                    @if(isset($billing_address->phone)){{$billing_address->phone}}
                                                    <br>@endif
                                                    @if(isset($customer->email)) {{$customer->email}} @endif
                                                </p>
                                            </td>
                                        @endif
                                    @endif
                                </tr>
                                </tbody>
                            </table>


                        </td>
                    </tr>
                    </tbody>
                </table>
            </center>
        </td>
    </tr>
    </tbody>
</table>
