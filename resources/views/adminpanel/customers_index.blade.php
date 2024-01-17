@extends('adminpanel.user-layout.default')
@section('content')
    <div class="col-lg-12 col-md-12 p-4">
        <div class=" px-3 pt-3  bg-white" style="border-radius: 3px;border:1px solid lightgrey;">
            <form method="GET" action="{{route('customers')}}">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="number" placeholder="Total Orders" name="total_orders"
                                   value="{{$total_orders}}" class="form-control"/>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <select name="num_of_days" id="" class="form-control">
                                <option value="{{null}}" selected>Last order date</option>
                                @foreach(CustomerModel::NUM_OF_DAYS as $days)
                                    <option @if(isset($num_of_days) && $days == $num_of_days) selected @endif  value="{{ $days }}">{{ $days }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <select name="accepts_marketing" id="" class="form-control">
                                <option value="{{null}}" selected>Accepts marketing</option>
                                <option @if(isset($selected_accepts_marketing) && $selected_accepts_marketing == 1) selected @endif  value="1">yes</option>
                                <option @if(isset($selected_accepts_marketing) && $selected_accepts_marketing == 0) selected @endif  value="0">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="number" placeholder="Total Spents" name="total_spents"
                                   value="{{$total_spents}}" class="form-control"/>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <?php
                        //                        $product_types = \App\Product::select('product_type')->distinct()->get();
                        ?>
                        <select class="form-control" name="country">
                            <option value="{{null}}" selected>Select Country</option>
                            @foreach($countries as $country)
                                @if($country!==null && $country!=='')
                                    <option @if($country==$filter_country) selected
                                            @endif value="{{$country}}">{{$country}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn  btn-primary">Filter</button>
                        @if(isset($total_orders) || isset($filter_country) || isset($total_spents) || isset($selected_accepts_marketing) || isset($num_of_days))
                            <a href="{{route('customers')}}" class="ml-3 btn  btn-danger">Reset</a>
                        @endif
                    </div>
                </div>

            </form>
        </div>
        <!-- start info box -->
        <div class="row ">
            <div class="col-md-12 pl-3 pt-2" style="margin: auto;">
                <div class="card" style="width: 100%">
                    <div class="card-header" style="background: white;">
                        <div class="row ">
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <div class="col-md-12 px-3 pt-2">
                                <div class="d-flex justify-content-between align-items-center mr-2">
                                    <h5>Customers</h5>
                                    <div>
                                        <a class="btn btn-primary" href="{{route('customer-export')}}">Customers
                                            Export</a>
                                        <a class="btn btn-primary" href="{{route('customer-push')}}">Customers Sync to
                                            Enterprise Platform</a>
                                        <a class="btn btn-primary" href="{{route('customer-sync')}}">Customer Sync</a>
                                    </div>

                                    {{--                                    <div>--}}
                                    {{--                                        <a href="{{route('welcome-campaign')}}"><button class="btn-primary">Welcome Campaign</button></a>--}}
                                    {{--                                        <a href="{{route('abandoned-cart-campaign')}}"><button class="btn-primary">Abandoned Cart Campaign</button></a>--}}
                                    {{--                                    </div>--}}

                                    {{--                                    <div >--}}
                                    {{--                                        <a style="display: inline-block;" type="submit" href=""   class="btn btn-sm btn-primary text-white"  >Sync Collections</a>--}}

                                    {{--                                        <form style="display: inline-block;" action="" method="post">--}}
                                    {{--                                            @csrf--}}
                                    {{--                                            <button type="submit"   class="btn btn-sm btn-primary text-white"  >Sync Products</button>--}}
                                    {{--                                        </form>--}}
                                    {{--                                    </div>--}}
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card-body">
                        <div id="product_append">
                            <div class="row px-3" style="overflow-x:auto;">

                                <table id="datatabled" class="table table-borderless  table-hover  table-class ">
                                    <thead class="border-0 ">

                                    <tr class="th-tr table-tr text-white text-center">
                                        <th class="font-weight-bold ">Name</th>
                                        {{-- <th class="font-weight-bold " >Last Name</th> --}}
                                        <th class="font-weight-bold ">Email</th>
                                        <th class="font-weight-bold ">Phone</th>
                                        <th class="font-weight-bold ">Country</th>
                                        <th class="font-weight-bold ">Total Orders</th>
                                        <th class="font-weight-bold ">Last Order Date</th>
                                        <th class="font-weight-bold ">Accepts Marketing</th>
                                        <th class="font-weight-bold ">Total Spent</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {{--                                        @dd($users_data)--}}
                                    @if($customers_data->count())
                                        @foreach($customers_data as $key=>$customer)

                                            <tr class="td-text-center">
                                                <td>
                                                    {{isset($customer->first_name)?($customer->first_name):null}} {{isset($customer->last_name)?($customer->last_name):null}}
                                                </td>
                                                <td>
                                                    {{$customer->email}}
                                                </td>
                                                <td>
                                                    @if($customer->phone)
                                                        {{$customer->phone}}
                                                    @elseif(isset($customer->addressess[0]->phone))
                                                        {{$customer->addressess[0]->phone}}
                                                    @else
                                                        <div class="badge badge-primary text-light p-1">Not Found</div>
                                                    @endif
                                                </td>
                                                @php
                                                    #dd($customer->addressess->first()->country);
                                                @endphp
                                                <td>
                                                    @if(isset($customer->addressess->first()->country))
                                                        {{$customer->addressess->first()->country}}
                                                    @endif
                                                </td>
                                                {{-- <td>
                                                    <div class=" py-1 px-3">{{$customer->orders->count()}}</div>
                                                </td> --}}
                                                <td>
                                                    <div class=" py-1 px-3">{{$customer->orders_count}}</div>
                                                </td>
                                                @php
                                                    $last_order_date = null;
                                                        if(isset($customer->last_order_date)){
                                                            $last_order_date = date_format (new DateTime($customer->last_order_date), 'M, d Y H:iA');;
                                                        }
                                                @endphp
                                                <td>
                                                    <div class=" py-1 px-3">{{isset($last_order_date)?$last_order_date:"--"}}</div>
                                                </td>
                                                <td>
                                                    @if($customer->accepts_marketing==1 )
                                                        <button class="btn btn-success btn-sm">Yes</button>
                                                    @endif
                                                    @if ($customer->accepts_marketing==0)

                                                        <button class="btn btn-danger btn-sm">No</button>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div
                                                        class="  py-1 px-3">{!! number_format((float)($customer->total_spent),2) !!}
                                                        £
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr class="td-text-center">
                                            <td colspan="8" class="text-center">
                                                -- No Customers Data Found
                                            </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                                @if($customers_data->count())
                                    {!!  $customers_data->links() !!}
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
{{--
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        console.log($(".acceptMarketingCss").val())
    })
</script> --}}
