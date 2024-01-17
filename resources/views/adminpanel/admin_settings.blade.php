@extends('adminpanel.layout.default')
<link rel="stylesheet" href="{{asset('tagify-master/tagify.css')}}">
<script src="{{asset('tagify-master/tagify.min.js')}}"></script>
@section('content')
    <div class="col-lg-12 col-md-12 p-4">
        <!-- start info box -->
        <div class="card col-md-12">
            <div class="card-header bg-white pb-1">
                <h5>Email Address</h5>
            </div>

            <form action="{{route('admin-email')}}" method="post">
                <div class="card-body col-md-12">
                    <div class="row px-3" style="overflow-x:auto;">
                        <div class="card-body">
                            <div class="row">

                                @csrf
                                <div class="col-md-12 m-auto">
                                    <div class="form-group">
                                        <label for="#">Admin Emails</label>
                                        <input  class="form-control"  name="email" value="@if(isset($admin_emails)){{$admin_emails->email}}@endif">

                                    </div>
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-primary" value="Add">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>

@endsection
@section('js_after')
    <script>
        $(document).ready(function(){
            // The DOM element you wish to replace with Tagify
            var input = document.querySelector('input[name=email]');
            // initialize Tagify on the above input node reference
            new Tagify(input)
        });

    </script>
@endsection
