@extends('layout.default')
<link href="{{asset('zoomify/dist/zoomify.min.css')}}" rel="stylesheet">
<style>
    .min-max-w-220 {
        min-width: 220px !important;
        max-width: 220px !important;
    }

    .accordion-parent {
        margin-bottom: 15px !important;
    }

</style>
<style>
    body img {
        width: 100% !important;
        margin-top: 8px;
        border: 1px solid lightgrey;
    }
    hr {
        margin: 2rem 0 !important;
    }
    .card-body img, .card-title img, .card-prompt img {
        display: block;
        width: 100% !important;
        max-width: none !important;
    }
    .accordion:hover {
        background-color: white !important;
    }

    .accordion {
        /*font-size: 18px;*/
        /*border-radius: 5px;*/
        background-color: transparent;
        /*color: gray;*/
        font-weight: 500;
        cursor: pointer;
        padding: 10px 20px;
        border-bottom: 1px solid lightgray !important;
        width: 100%;
        text-align: left;
        outline: none;
        border: none;
        transition: 0.4s;
    }

    .accordion:focus {
        outline: none;
    }

    /*.active, .accordion:hover {*/
    /*    background-color: lightgrey;*/
    /*}*/

    .accordion:after {
        content: '\002B';
        /*font-size: 20px;*/
        /*color: gray;*/
        font-weight: bold;
        float: right;
        margin-left: 5px;
    }

    .custum-active:after {
        content: "\2212";
        /*font-size: 20px;*/
        /*color: gray;*/
    }

    .panel {
        padding: 0 18px;
        background-color: white;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.2s ease-out;
    }
</style>
@section('content')
    @php
        $tracking = "{{ fulfillment.tracking_url }}" ;
        $replace_code = "https://{{ shop.domain }}/apps/view/track-order/{{ fulfillment.tracking_numbers.first }}" ;
    @endphp
    <div class="container " style="max-width:60% !important;min-height: 500px;">
        <div class="row pr-0">
            <div class="col-lg-12 col-md-12 pt-3 pr-0">
                <div class="">
                    <div class="accordion-parent">
                        <button class="accordion   bg-white pt-2 " style="background-color: white !important;">How does
                            the app works?
                        </button>

                        <div class="panel ">
                            <p class="mt-3">
                                This app lets you keep your customers updated on their orders. It will be able to
                                configure set your milestones and update each order automatically based on its progress.
                            <ol class="mt-3">
                                <li>You need to activate the one template from <b>'templates'</b> tab also you can
                                    customize your selected template.
                                </li>
                                <li>Automatically your new store orders will be sync in your 'Orders tab' according to
                                    your selected plan. Then you can also fulfill your orders within the app.
                                </li>
                                <li>You need to do email setup to send tracking order page link to your customers by
                                    follow <b>'Email Setup'</b> tab instructions. Once you done, then after fulfillment
                                    of your order, tracking page email link will be send automatically to your customer.
                                    From that link he will be able to track his/her order.
                                </li>
                                <li>In configuration tab, you can set your app configurations (hide or display details
                                    like carrier details, tracking numbers, estimate deliver date, can be add custom
                                    html, css on you tracking page, carrier mapping, etc)
                                </li>
                            </ol>
                            </p>

                        </div>
                    </div>
                    <div class="accordion-parent">
                        <button class="accordion   bg-white pt-2 " style="background-color: white !important;">How to
                            subscribe the plans?
                        </button>
                        <div class="panel">

                            <ol class="mt-3">
                                <li>Go to <b>'Billing > Plans'</b> tab.</li>
                                <li>You need to press <b>'Upgrade Plan'</b> button, it will redirect you on shopify
                                    billing portal then you will pay and enjoy your subscription.
                                </li>
                                <li>Under <b>'Billing > Invoices'</b> tab you can view or download your subscribed plan
                                    invoices.
                                </li>
                            </ol>
                        </div>
                    </div>

                    <div class="accordion-parent">
                        <button class="accordion   bg-white pt-2 " style="background-color: white !important;">How to
                            track the order via tracking page?
                        </button>
                        <div class="panel">
                            <ol class="mt-3">
                                <li>Go to your <b>'Orders > View'</b> tab.</li>
                                <li>Once your checking order will fulfilled from our app after adding tracking number,Then you can see that button 'View Tracking Page'.</li>
                                <li>Press <b>'View Tracking Page'</b> button to track your order details.</li>
                            </ol>
                        </div>
                    </div>

                    <div class="accordion-parent">
                        <button class="accordion   bg-white pt-2 " style="background-color: white !important;">How to
                            send the Tracking Page link via email?
                        </button>
                        <div class="panel">
                            <ol class="mt-3">
                                <li><span
                                        style="background-color: #ffa44f"><b>Follow all instruction <b>'Email Setup'</b> tab.</b></span>
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="accordion-parent">
                        <button class="accordion   bg-white pt-2 " style="background-color: white !important;">
                            How to uninstall instructions once your app is uninstalled from a shop?
                        </button>
                        <div class="panel">
                            <ol class="mt-3">
                                <li>
                                    After uninstalling the app, please make sure to revert or remove added code from notification email templates.
                                    <p class="mt-3"><b>Here are the steps:</b> </p>
                                    <ul>
                                        <li>Go to store <b>'Dashboard > Settings > Notifications'</b> tab. </li>
                                        <li>You will see a list of all the notification emails Shopify sends by default.</li>
                                        <li>Click on the “Shipping confirmation” template. </li>
                                        <li>Find this code <b>{{$replace_code}}</b> and replace with <b>{{$tracking}}</b></li>
                                        <li>Press save button.</li>
                                        <li>
                                            Do all previous steps same with the other mentioned notifications options like <b>'Notification > Shipping confirmation, Shipping update, Out of delivery, Delivered, Local delivery(Delivered)' tabs.</b>
                                            <img class="zoom-img" src="{{asset('instructions/all_options.jpg')}}">
                                        </li>
                                    </ul>
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="accordion-parent">
                        <button class="accordion   bg-white pt-2 " style="background-color: white !important;">Still you
                            need of guidence? Don't Worry !
                        </button>
                        <div class="panel">

                            <ol class="mt-3">
                                <li><b>Having trouble?</b> We're here to point you in the right direction and ensure
                                    Customer Fields is running smoothly on your store. <a
                                        target="_blank" style="text-decoration: underline !important;"  href="mailto:support@webinopoly.com">Click Here</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

@endsection

@section('js_after')
    <script>
        var acc = document.getElementsByClassName("accordion");
        var i;
        acc[0].classList.toggle("custom-active");
        var panel = acc[0].nextElementSibling;
        if (panel.style.maxHeight) {
            panel.style.maxHeight = null;
        } else {
            panel.style.maxHeight = panel.scrollHeight + "px";
        }

        for (i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function () {
                this.classList.toggle("custom-active");
                var panel = this.nextElementSibling;
                if (panel.style.maxHeight) {
                    panel.style.maxHeight = null;
                } else {
                    panel.style.maxHeight = panel.scrollHeight + "px";
                }
            });
        }

    </script>
    <script src="{{asset('zoomify/dist/zoomify.min.js')}}"></script>

    <script>
        $(document).ready(function () {
            $('.zoom-img').zoomify();
        });
    </script>

@endsection
