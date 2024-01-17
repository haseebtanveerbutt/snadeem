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
                            <h3 style="font-weight: normal; font-size: 20px; margin: 0 0 25px;">Order Summary</h3>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table class="container"
                       style="width: 560px; text-align: left; border-spacing: 0; border-collapse: collapse; margin: 0 auto;">
                    <tbody>
                    <tr>
                        <td style="font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Roboto&quot;, &quot;Oxygen&quot;, &quot;Ubuntu&quot;, &quot;Cantarell&quot;, &quot;Fira Sans&quot;, &quot;Droid Sans&quot;, &quot;Helvetica Neue&quot;, sans-serif;">


                            <table class="row"
                                   style="width: 100%; border-spacing: 0; border-collapse: collapse;">

                                <tbody>
                                @foreach(json_decode($order->line_items) as $key=>$line_item)
                                    <tr class="order-list__item" style="width: 100%;">
                                        <td class="order-list__item__cell"
                                            style="font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Roboto&quot;, &quot;Oxygen&quot;, &quot;Ubuntu&quot;, &quot;Cantarell&quot;, &quot;Fira Sans&quot;, &quot;Droid Sans&quot;, &quot;Helvetica Neue&quot;, sans-serif; padding-bottom: 15px;">
                                            <table style="border-spacing: 0; border-collapse: collapse;">
                                                <tbody>
                                                <tr>
                                                    <td style="font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Roboto&quot;, &quot;Oxygen&quot;, &quot;Ubuntu&quot;, &quot;Cantarell&quot;, &quot;Fira Sans&quot;, &quot;Droid Sans&quot;, &quot;Helvetica Neue&quot;, sans-serif;">

                                                        <img
                                                            src="{{isset($line_item->image)?$line_item->image:null}}"
                                                            align="left" width="60" height="60"
                                                            class="order-list__product-image"
                                                            style="margin-right: 15px; border-radius: 8px; border: 1px solid #e5e5e5;">

                                                    </td>
                                                    <td class="order-list__product-description-cell"
                                                        style="font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Roboto&quot;, &quot;Oxygen&quot;, &quot;Ubuntu&quot;, &quot;Cantarell&quot;, &quot;Fira Sans&quot;, &quot;Droid Sans&quot;, &quot;Helvetica Neue&quot;, sans-serif; width: 100%;">


                                                                <span class="order-list__item-title" style="font-size: 16px; font-weight: 600; line-height: 1.4; color: #555;">{{ucwords($line_item->title)}}&nbsp;×&nbsp;{{$line_item->quantity}}</span><br>


                                                        @if(isset($line_item->variant_title) && $line_item->variant_title != "")<span class="order-list__item-variant" style="font-size: 14px; color: #999;">{{isset($line_item->variant_title)?$line_item->variant_title:null}}</span><br>@endif
                                                        @if(isset($line_item->sku) && $line_item->sku != "")<span class="order-list__item-variant" style="font-size: 14px; color: #999;">{{isset($line_item->sku)?"SKU: ".$line_item->sku:null}}</span><br>@endif

                                                    </td>
                                                    <td class="order-list__price-cell"
                                                        style="font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Roboto&quot;, &quot;Oxygen&quot;, &quot;Ubuntu&quot;, &quot;Cantarell&quot;, &quot;Fira Sans&quot;, &quot;Droid Sans&quot;, &quot;Helvetica Neue&quot;, sans-serif; white-space: nowrap;">

                                                        <p class="order-list__item-price"
                                                           style="color: #555; line-height: 150%;  font-weight: 600; margin: 0 0 0 15px;"
                                                           align="right">

                                                            {{$order->currency." "}}{{number_format($line_item->price * $line_item->quantity,2)}}

                                                        </p>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <table class="row subtotal-lines"
                                   style="width: 100%; border-spacing: 0; border-collapse: collapse; margin-top: 0px; border-top-width: 1px; border-top-color: #e5e5e5; border-top-style: solid;">
                                <tbody>
                                <tr>
                                    <td class="subtotal-spacer"
                                        style="font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Roboto&quot;, &quot;Oxygen&quot;, &quot;Ubuntu&quot;, &quot;Cantarell&quot;, &quot;Fira Sans&quot;, &quot;Droid Sans&quot;, &quot;Helvetica Neue&quot;, sans-serif; width: 40%;"></td>
                                    <td style="font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Roboto&quot;, &quot;Oxygen&quot;, &quot;Ubuntu&quot;, &quot;Cantarell&quot;, &quot;Fira Sans&quot;, &quot;Droid Sans&quot;, &quot;Helvetica Neue&quot;, sans-serif;">
                                        <table class="row subtotal-table"
                                               style="width: 100%; border-spacing: 0; border-collapse: collapse; margin-top: 10px;">


                                            <tbody>
                                            @php
                                                $total_shipping = $order->total_shipping_price_set;
                                                if(isset($total_shipping) && $total_shipping != ""){
                                                    $total_shipping = json_decode($total_shipping);
                                                    $total_shipping = $total_shipping->shop_money->amount;
                                                }

                                            @endphp
                                            <tr class="subtotal-line">
                                                <td class="subtotal-line__title"
                                                    style="font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Roboto&quot;, &quot;Oxygen&quot;, &quot;Ubuntu&quot;, &quot;Cantarell&quot;, &quot;Fira Sans&quot;, &quot;Droid Sans&quot;, &quot;Helvetica Neue&quot;, sans-serif; padding: 5px 0;">
                                                    <p style="color: #777; line-height: 1.2em; font-size: 16px; margin: 0;">
                                                        <span style="font-size: 16px;">Subtotal</span>
                                                    </p>
                                                </td>
                                                <td class="subtotal-line__value"
                                                    style="font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Roboto&quot;, &quot;Oxygen&quot;, &quot;Ubuntu&quot;, &quot;Cantarell&quot;, &quot;Fira Sans&quot;, &quot;Droid Sans&quot;, &quot;Helvetica Neue&quot;, sans-serif; padding: 5px 0;"
                                                    align="right">
                                                    <strong
                                                        style=" color: #555;">{{$order->currency." "}}{{number_format($order->subtotal_price,2)}}</strong>
                                                </td>
                                            </tr>


                                            <tr class="subtotal-line">
                                                <td class="subtotal-line__title"
                                                    style="font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Roboto&quot;, &quot;Oxygen&quot;, &quot;Ubuntu&quot;, &quot;Cantarell&quot;, &quot;Fira Sans&quot;, &quot;Droid Sans&quot;, &quot;Helvetica Neue&quot;, sans-serif; padding: 5px 0;">
                                                    <p style="color: #777; line-height: 1.2em; font-size: 16px; margin: 0;">
                                                        <span style="font-size: 16px;">Shipping</span>
                                                    </p>
                                                </td>
                                                <td class="subtotal-line__value"
                                                    style="font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Roboto&quot;, &quot;Oxygen&quot;, &quot;Ubuntu&quot;, &quot;Cantarell&quot;, &quot;Fira Sans&quot;, &quot;Droid Sans&quot;, &quot;Helvetica Neue&quot;, sans-serif; padding: 5px 0;"
                                                    align="right">
                                                    <strong
                                                        style="color: #555;">{{$order->currency." "}}@if(isset($total_shipping) && $total_shipping != ""){{number_format($total_shipping,2)}}@else
                                                            0.00 @endif</strong>
                                                </td>
                                            </tr>


                                            <tr class="subtotal-line">
                                                <td class="subtotal-line__title"
                                                    style="font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Roboto&quot;, &quot;Oxygen&quot;, &quot;Ubuntu&quot;, &quot;Cantarell&quot;, &quot;Fira Sans&quot;, &quot;Droid Sans&quot;, &quot;Helvetica Neue&quot;, sans-serif; padding: 5px 0;">
                                                    <p style="color: #777; line-height: 1.2em; font-size: 16px; margin: 0;">
                                                        <span style="font-size: 16px;">Taxes</span>
                                                    </p>
                                                </td>
                                                <td class="subtotal-line__value"
                                                    style="font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Roboto&quot;, &quot;Oxygen&quot;, &quot;Ubuntu&quot;, &quot;Cantarell&quot;, &quot;Fira Sans&quot;, &quot;Droid Sans&quot;, &quot;Helvetica Neue&quot;, sans-serif; padding: 5px 0;"
                                                    align="right">
                                                    <strong
                                                        style="color: #555;">{{$order->currency." "}}{{isset($order->current_total_tax)?number_format($order->current_total_tax,2):'0.00'}}</strong>
                                                </td>
                                            </tr>


                                            </tbody>
                                        </table>


                                        <table class="row subtotal-table subtotal-table--total"
                                               style="width: 100%; border-spacing: 0; border-collapse: collapse; margin-top: 10px; border-top-width: 2px; border-top-color: #e5e5e5; border-top-style: solid;">


                                            <tbody>
                                            <tr class="subtotal-line">
                                                <td class="subtotal-line__title"
                                                    style="font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Roboto&quot;, &quot;Oxygen&quot;, &quot;Ubuntu&quot;, &quot;Cantarell&quot;, &quot;Fira Sans&quot;, &quot;Droid Sans&quot;, &quot;Helvetica Neue&quot;, sans-serif; padding: 20px 0 0;">
                                                    <p style="color: #777; line-height: 1.2em; font-size: 16px; margin: 0;">
                                                        <span style="font-size: 16px;">Total</span>
                                                    </p>
                                                </td>
                                                <td class="subtotal-line__value"
                                                    style="font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Roboto&quot;, &quot;Oxygen&quot;, &quot;Ubuntu&quot;, &quot;Cantarell&quot;, &quot;Fira Sans&quot;, &quot;Droid Sans&quot;, &quot;Helvetica Neue&quot;, sans-serif; padding: 20px 0 0;"
                                                    align="right">
                                                    <strong style=" color: #555;">{{$order->currency." "}}{{number_format($order->total_price,2)}}</strong>
                                                </td>
                                            </tr>


                                            </tbody>
                                        </table>

                                    </td>
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
