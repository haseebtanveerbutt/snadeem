@extends('adminpanel.layout.default')
<link rel="stylesheet" type="text/css" href="{{asset('daterangepicker-master/daterangepicker.css')}}"/>

<style>
    .daterangepicker.ltr.show-ranges.opensleft {
        top: 56px !important;
    }
</style>
@section('content')
    <div class="container">
        <div class="row" style="margin-top: 0 !important;">
            <div class="col-lg-6  pb-2 pr-2"
                 style="background-image: url({{asset('main.png')}}) !important; background-size: 80% ; background-repeat: no-repeat; background-position: 15rem -5rem">
                <div class="greeting mt-4 ">
                    <h3>
                        Welcome, {{\Illuminate\Support\Facades\Auth::user()->name}}
                    </h3>
                    <h4 class="text-muted w-50 fw-normal">
                        Here's what's happening with your store today.
                    </h4>
                </div>

{{--                <div class="row store-insight">--}}
{{--                    <div class="col-5">--}}
{{--                        <div>Today's Sales</div>--}}
{{--                        <h4 class="fw-normal">--}}
{{--                            $8900.00--}}
{{--                        </h4>--}}
{{--                    </div>--}}
{{--                    <div class="col-5">--}}
{{--                        <div>Today's Visits</div>--}}
{{--                        <h4 class="fw-normal">--}}
{{--                            37849--}}
{{--                        </h4>--}}
{{--                    </div>--}}

{{--                </div>--}}

                <div class="row mt-4">
                    <div class="col-12" style="min-height: 400px;">

                    </div>
                </div>
            </div>


            <div class="col-lg-6 pb-2 bg-white shadow-sm border-left border-white">

                <form method="get" action="{{route('admin.dashboard')}}">
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
                            <a style="padding-top: 5px !important;" href="{{route('admin.dashboard')}}"
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

{{--                <small class="fw-bold mx-4">TOTAL SALES BY CHANNEL</small>--}}
{{--                <ul class="list-group list-group-flush">--}}
{{--                    <li class="list-group-item">--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-md-6">--}}
{{--                                <span style="text-decoration: none !important">Front Store</span>--}}
{{--                                <h5 class="mt-2">$44,430.00</h5>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-6 text-right">--}}
{{--                                <a href="#" class="btn btn-link text-right d-block p-0">View dashboard</a>--}}
{{--                                <span class="text-muted">445,342 orders</span>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </li>--}}
{{--                    <li class="list-group-item">--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-md-6">--}}
{{--                                <span style="text-decoration: none !important">Mobile Store</span>--}}
{{--                                <h5 class="mt-2">$3,932.00</h5>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-6 text-right">--}}
{{--                                <a href="#" class="btn btn-link text-right d-block p-0">View dashboard</a>--}}
{{--                                <span class="text-muted">32,322 orders</span>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </li>--}}
{{--                </ul>--}}
            </div>
        </div>

    </div>
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
    </script>
@endsection
