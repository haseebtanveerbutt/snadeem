@extends('app.layout.default')
@section('content')
    <div class="container" style="min-height: 510px;">

        <div class="col-lg-12 col-md-12 ">
            <div class="col-md-12 padding-0 my-2">
                <div class="d-flex justify-content-between align-items-center"
                     style="margin-bottom: 16px !important;">
                    <h5 style="margin-bottom: 0 !important;">Settings</h5>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('setting_save')}}" method="post">
                            @sessionToken
                            <div class="row">
                                <div class="col-md-4">
                                    <p style="font-size: 16px;
    font-weight: 600;">API URL</p>
                                </div>
                                <div class="col-md-8">
                                    <input class="form-control" name="api_url" value="{{isset($setting) && isset($setting->api_url)?$setting->api_url:null}}">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <p style="font-size: 16px;
    font-weight: 600;">API AUTH Key</p>
                                </div>
                                <div class="col-md-8">
                                    <input class="form-control" name="auth_key" value="{{isset($setting) && isset($setting->auth_key)?$setting->auth_key:null}}">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <button type="submit" class="btn btn-primary btn-sm">Save</button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
