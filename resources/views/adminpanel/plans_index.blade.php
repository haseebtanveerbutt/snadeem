@extends('adminpanel.layout.default')
@section('content')
    <div class="container">

        <div class="col-lg-12 col-md-12 p-4 ">
            <!-- start info box -->
            <div class="row mt-0">
                <div class="col-md-12 pl-3 pb-2" style="margin: auto;">
                    <div class="d-flex justify-content-between mb-4">
                        <h5 style="margin-bottom: 0 !important;">Plans</h5>
                        <button type="button" data-toggle="modal" data-target="#AddPlanModal"
                                class="btn btn-sm btn-primary">Add Plan
                        </button>
                    </div>
                    <div class="card" style="width: 100%">
                            {{--                              Modal--}}
                            <div aria-hidden="true" class="modal fade" id="AddPlanModal" role="dialog" tabindex="-1">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Add Plan</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <form action="{{Route('plan-save')}}" method="post">
                                            @csrf

                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label class="text-left" for="#">Type</label>
                                                    <select name="type" class="form-control">
                                                        <option value="RECURRING" selected>RECURRING</option>
                                                        {{--                                                            <option value="ONETIME ">ONETIME </option>--}}
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="text-left" for="#">Name</label>
                                                    <input value="" name="name" type="text" class="form-control name">
                                                </div>


                                                <div class="form-group">
                                                    <label class="text-left">Price </label>
                                                    <input name="price" step="any" type="number"
                                                           class="form-control weight">
                                                </div>
                                                <div class="form-group">
                                                    <label class="text-left" for="#">Capped Amount</label>
                                                    <input name="capped_amount" step="any" type="number"
                                                           class="form-control weight">
                                                </div>
                                                <div class="form-group">
                                                    <label class="text-left" for="#">Interval</label>
                                                    <select name="interval" class="form-control">
                                                        <option value="EVERY_30_DAYS  " selected>EVERY_30_DAYS</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="text-left" for="#">Terms</label>
                                                    <textarea name="terms" class="form-control weight"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label class="text-left" for="#">Trial Days</label>
                                                    <input name="trial_days" type="number" class="form-control weight">
                                                </div>
                                                {{--                                                    <div class="form-group">--}}
                                                {{--                                                        <label class="text-left"  for="#">Select Subscription Status</label>--}}
                                                {{--                                                        <select class="form-control " name="status" >--}}
                                                {{--                                                            <option selected value="active">Active</option>--}}
                                                {{--                                                            <option  value="inactive">Inactive</option>--}}
                                                {{--                                                        </select>--}}
                                                {{--                                                    </div>--}}

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                    Close
                                                </button>
                                                <button type="submit" class="SaveRule btn btn-primary ">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            {{--                              Modal End--}}
                        <div class="card-body">
                            <div id="product_append">
                                <div class="row px-3" style="overflow-x:auto;margin-top: 0;margin-bottom: 0;">

                                    <table id="datatabled" class="table table-borderless  table-hover  table-class ">
                                        <thead class="border-0 ">

                                        <tr class="th-tr table-tr text-center">
                                            <th class="font-weight-bold ">Type</th>
                                            <th class="font-weight-bold ">Name</th>
                                            <th class="font-weight-bold ">Price</th>
                                            <th class="font-weight-bold ">Interval</th>
                                            <th class="font-weight-bold ">Capped Amount</th>
                                            <th class="font-weight-bold ">Terms</th>
                                            <th class="font-weight-bold ">Trial Days</th>
                                            {{--                                        <th class="font-weight-bold " >Status</th>--}}
                                            <th class="font-weight-bold " style="width: 10%">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        {{--                                        @dd($users_data)--}}
                                        @foreach($plans_data as $key=>$plan)

                                            <tr class="td-text-center">
                                                <td>
                                                    {{$plan->type}}
                                                </td>
                                                <td>
                                                    {{ $plan->name }}
                                                </td>
                                                <td>
                                                    ${{number_format($plan->price,2)}}
                                                </td>
                                                <td>
                                                    {{$plan->interval}}
                                                </td>
                                                <td>
                                                    ${{number_format($plan->capped_amount,2)}}
                                                </td>
                                                <td>
                                                    {{$plan->terms}}
                                                </td>
                                                <td>
                                                    {{$plan->trial_days}}
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm float-right" role="group"
                                                         aria-label="Basic example">
                                                        <button type="button"
                                                                class="btn  w-100 btn-sm btn-primary edit-package"
                                                                data-toggle="modal"
                                                                data-target="#EditPlanModal{{$key}}">Edit
                                                        </button>
                                                        {{--                              Modal--}}
                                                        <div aria-hidden="true" class="modal fade edit-package"
                                                             id="EditPlanModal{{$key}}" role="dialog" tabindex="-1">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                                            Edit Plan</h5>
                                                                        <button type="button" class="close"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>

                                                                    <form
                                                                        action="{{Route('edit-plan-save', $plan->id)}}"
                                                                        method="post">
                                                                        @csrf
                                                                        <div class="modal-body">
                                                                            <div class="form-group">
                                                                                <label class="text-left"
                                                                                       for="#">Type</label>
                                                                                <select name="type"
                                                                                        class="form-control">

                                                                                    <option value="RECURRING" selected>
                                                                                        RECURRING
                                                                                    </option>
                                                                                    {{--                                                                                <option value="ONETIME " @if(isset($plan->type) && $plan->type == 'ONETIME') selected @endif>ONETIME </option>--}}
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="text-left"
                                                                                       for="#">Name</label>
                                                                                <input value="{{$plan->name}}"
                                                                                       name="name" type="text"
                                                                                       class="form-control name">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="text-left">Price</label>
                                                                                <input value="{{$plan->price}}"
                                                                                       name="price" step="any"
                                                                                       type="number"
                                                                                       class="form-control weight">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="text-left" for="#">Capped
                                                                                    Amount</label>
                                                                                <input value="{{$plan->capped_amount}}"
                                                                                       name="capped_amount" step="any"
                                                                                       type="number"
                                                                                       class="form-control weight">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="text-left" for="#">Interval</label>
                                                                                <select name="interval"
                                                                                        class="form-control">
                                                                                    <option value="EVERY_30_DAYS  "
                                                                                            selected>EVERY_30_DAYS
                                                                                    </option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="text-left"
                                                                                       for="#">Terms</label>
                                                                                <textarea name="terms"
                                                                                          class="form-control weight">{{$plan->terms}}</textarea>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="text-left" for="#">Trial
                                                                                    Days</label>
                                                                                <input value="{{$plan->trial_days}}"
                                                                                       name="trial_days" type="number"
                                                                                       class="form-control weight">
                                                                            </div>
                                                                            {{--                                                                        <div class="form-group">--}}
                                                                            {{--                                                                            <label class="text-left"  for="#">Select Subscription Status</label>--}}
                                                                            {{--                                                                            <select class="form-control " name="status" >--}}
                                                                            {{--                                                                                <option selected value="active">Active</option>--}}
                                                                            {{--                                                                                <option  value="inactive">Inactive</option>--}}
                                                                            {{--                                                                            </select>--}}
                                                                            {{--                                                                        </div>--}}

                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    data-dismiss="modal">Close
                                                                            </button>
                                                                            <button type="submit"
                                                                                    class="SaveRule btn btn-primary ">
                                                                                Save
                                                                            </button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{--                              Modal End--}}

                                                        <button type="submit" data-toggle="modal"
                                                                data-target="#delete_plan{{$key}}"
                                                                class="btn btn-sm btn-danger w-100 DeleteBtn">Delete
                                                        </button>
                                                        <div class="modal fade" id="delete_plan{{$key}}"
                                                             style=" margin-top: 30px;" tabindex="-1"
                                                             aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-scrollable ">
                                                                <div class="modal-content">
                                                                    <form method="post"
                                                                          action="{{route('delete-plan',$plan->id)}}">
                                                                        @csrf
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Delete Plan</h5>
                                                                            <button type="button" class="close"
                                                                                    data-dismiss="modal"
                                                                                    aria-label="Close">&times;
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="row my-3">
                                                                                <div class="col-md-12">
                                                                                    <p style="font-size: 16px;">Are you
                                                                                        sure you want to delete
                                                                                        plan?</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                    class="btn btn-danger btn-sm"
                                                                                    data-dismiss="modal">Close
                                                                            </button>
                                                                            <button type="submit"
                                                                                    class="btn  btn-sm btn-primary">Yes
                                                                            </button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    {{--                                {!!  $customers_data->links() !!}--}}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
