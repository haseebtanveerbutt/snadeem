@extends('app.layout.default')
<link rel="stylesheet" type="text/css" href="{{asset('daterangepicker-master/daterangepicker.css')}}"/>

<style>
    .daterangepicker.ltr.show-ranges.opensleft {
        top: 56px !important;
    }
</style>
<style>
    body {
        padding-bottom: 0 !important;
        overflow: hidden !important;
    }

    .container {
        overflow: hidden !important;
    }

    .daterangepicker.ltr.show-ranges.opensleft {
        right: 376px !important;
    }
</style>
{{--wizard css--}}
@section('content')
    <div class="container" style="padding-right: 0%;margin-right: 0 !important;">
        <div class="row mt-0">
            <div class="col-lg-7 pb-2  pr-2"
                 style="padding-left: 26px !important;background-image: url({{asset('main.png')}}) !important; background-size: 80% ; background-repeat: no-repeat; background-position: 15rem -5rem">
                <div class="greeting mt-4 ">
                    <h3>
                        Welcome, {{\Illuminate\Support\Facades\Auth::user()->name}}
                    </h3>
                    <h4 class="text-muted w-50 fw-normal">
                        Here's what's happening with your store today.
                    </h4>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
{{--                        <div class="card border-warning-light my-4 py-2 mr-4 shadow-sm">--}}
{{--                            <div class="d-flex justify-content-between align-items-center pr-4">--}}
{{--                                <div>--}}
{{--                                    <ul class="list-group list-group-flush">--}}
{{--                                        <li class="list-group-item " style="padding-top: 0 !important;">--}}
{{--                                            <span class="d-block mb-2 fw-bold"></span>--}}
{{--                                            <ul style="padding-left: 20px !important;">--}}
{{--                                               <li>Lorum epsum</li>--}}
{{--                                               <li>Lorum epsum</li>--}}
{{--                                               <li>Lorum epsum</li>--}}
{{--                                            </ul>--}}
{{--                                        </li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                        </div>--}}
                    </div>
                </div>
            </div>


            <div class="col-lg-5 pt-2 pb-2 bg-white shadow-sm border-left border-white" style="min-height: 750px;">
                <form method="get" action="{{route('home')}}">
                    @sessionToken
                    <div class="row p-4">
                        <div class="col-md-9">
                            <div id="reportrange" class="pull-right"
                                 style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                <i class="fa fa-calendar"></i>&nbsp;
                                <span>{{isset($selected_date)?$selected_date:null}}</span>
                                <input class="date_range_input"
                                       data-search="{{isset($search)?$search:"no"}}"
                                       hidden
                                       value="{{isset($selected_date)?$selected_date:null}}"
                                       name="date_range"/> <i class="fa fa-caret-down" style="right: 18px !important;
    top: 8px;
    position: absolute;"></i>
                            </div>
                            <input hidden value="{{isset($selected_date)?$selected_date:null}}" class="date_range"/>
                        </div>
                        <div class="col-md-3 d-flex">
                            <button type="submit" style="margin-right: 4px;"
                                    class="  btn btn-primary btn-sm ">Search
                            </button>
                            <a style="padding-top: 5px !important;" href="{{route('home')}}"
                               class="btn-sm btn btn-primary btn-sm">Reset</a>
                        </div>
                    </div>
                </form>
                <hr class="m-0">

                <div class="row p-4">
                    <div class="col-md-6">
                        <small class="fw-bold">TOTAL SALES</small>
                        <h4 class="fw-normal">${{isset($total_sales)?number_format($total_sales,2):0.00}}</h4>
                    </div>
                    <div class="col-md-6 text-right text-muted">
                        <span>{{isset($order_counts)?$order_counts:0}} orders</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{--                @php--}}
    {{--                    $webhook=\Illuminate\Support\Facades\Auth::user()->api()->rest('GET','/admin/webhooks.json');--}}
    {{--                       dump($webhook);--}}
    {{--                @endphp--}}

@endsection

@section('script')
    {{--    daterange picker--}}
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.min.js"></script>
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/trianglify/0.2.1/trianglify.min.js"></script>
    <script type="text/javascript" src="{{asset('daterangepicker-master/daterangepicker.js')}}"></script>
    <script>
        $(function () {

            var start = moment().subtract(29, 'days');
            var end = moment();
            // var start = moment();
            // var end = moment();

            function cb(start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                $('#reportrange input').attr('value', start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }


            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb);

            cb(start, end);
            var data_range = $('.date_range').val();
            var data_range_arrays = data_range.split(' - ');
            var startDate = new Date("MMMM D, YYYY " + data_range_arrays[0]);
            var endDate = new Date("MMMM D, YYYY " + data_range_arrays[1]);
            if (data_range) {
                $('#reportrange span').html(data_range);
                $('#reportrange input').attr('value', data_range);

                $('#reportrange').daterangepicker({
                    startDate: startDate,
                    endDate: endDate,
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    }
                }, cb);
            }
        });
        $(document).ready(function () {

            var current_fs, next_fs, previous_fs; //fieldsets
            var opacity;

            $(".next").click(function () {

                current_fs = $(this).parent();
                next_fs = $(this).parent().next();

                //Add Class Active
                $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

                //show the next fieldset
                next_fs.show();
                //hide the current fieldset with style
                current_fs.animate({opacity: 0}, {
                    step: function (now) {
                        // for making fielset appear animation
                        opacity = 1 - now;

                        current_fs.css({
                            'display': 'none',
                            'position': 'relative'
                        });
                        next_fs.css({'opacity': opacity});
                    },
                    duration: 600
                });
            });

            $(".previous").click(function () {

                current_fs = $(this).parent();
                previous_fs = $(this).parent().prev();

                //Remove class active
                $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

                //show the previous fieldset
                previous_fs.show();

                //hide the current fieldset with style
                current_fs.animate({opacity: 0}, {
                    step: function (now) {
                        // for making fielset appear animation
                        opacity = 1 - now;

                        current_fs.css({
                            'display': 'none',
                            'position': 'relative'
                        });
                        previous_fs.css({'opacity': opacity});
                    },
                    duration: 600
                });
            });

            $('.radio-group .radio').click(function () {
                $(this).parent().find('.radio').removeClass('selected');
                $(this).addClass('selected');
            });

        });
    </script>
@endsection
