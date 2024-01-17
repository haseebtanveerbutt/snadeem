@extends('adminpanel.layout.default')
@section('content')
    <div class="col-lg-12 col-md-12 p-4">
        <!-- start info box -->
        <div class="card col-md-12">


            <div class="card-body col-md-12">
                <div class="row px-3" style="overflow-x:auto;">

                    <table id="datatabled" class="table table-borderless  table-hover  table-class ">
                        <thead class="border-0 ">

                        <tr class="th-tr table-tr text-white text-center">
                            <th class="font-weight-bold " >Name</th>
                            <th class="font-weight-bold " >Email</th>
                            <th class="font-weight-bold " >Subject</th>
                            <th class="font-weight-bold " >Message</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($contact_datas->count())
                            @foreach($contact_datas as $key=>$contact)

                                <tr class="td-text-center">
                                    <td>
                                        {{$contact->name}}
                                    </td>
                                    <td>
                                        {{$contact->email}}
                                    </td>
                                    <td>
                                        {{$contact->subject}}
                                    </td>
                                    <td>
                                        {{$contact->message}}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="text-center">
                                    -- No Contact-us Data
                                </td>
                            </tr>
                        @endif
                        {{--                                        @dd($users_data)--}}

                        </tbody>
                    </table>
                    @if($contact_datas->count())
                        {!!  $contact_datas->links() !!}
                    @endif
                </div>
            </div>

        </div>
    </div>

@endsection
@section('js_after')
    <script>
        $(document).ready(function(){

        });

    </script>
@endsection
