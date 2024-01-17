<body>

<nav class="navbar navbar-expand-lg " >
    <div>
        <a style="margin-left: 10px;" class="navbar-brand" href="{{Route('home')}}">
{{--            <img style="max-height: 65px;"src="{{asset('text-global-uk.jpg')}}">--}}
            Custom Pickups
        </a>
    </div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse custom-nav-collapse justify-content-center" id="navbarSupportedContent">
        <div class="text-center">
            <ul class="custom-ul navbar-nav mr-auto text-center">

                <li class="nav-item active">
                    <a class="nav-link @if(\Request::getPathInfo() == '/') active-line @endif"  href="{{route('home')}}">Dashboard<span class="sr-only"></span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link @if(\Request::getPathInfo() == '/orders') active-line @endif" href="{{route('orders')}}">Orders<span class="sr-only"></span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link @if(\Request::getPathInfo() == '/email/settings') active-line @endif" href="{{route('email.setting')}}">Settings<span class="sr-only"></span></a>
                </li>
            </ul>
        </div>
    </div>
    <div style="z-index: -99;">
        <a style="margin-left: 10px;" class="navbar-brand" href="https://omnie-app.test">
            Omnie Live Support
        </a>
    </div>


{{--    <div style="width: auto; " class="text-white mr-2 d-flex">--}}
{{--        @if(\Illuminate\Support\Facades\Auth::user()->credit > 0)--}}
{{--            <div style="--}}
{{--    color: white;background-color: #F4B340 ;--}}
{{--    padding: 5px 25px;    font-weight: 500;--}}
{{--    text-align: center;">{{"Credits - ". \Illuminate\Support\Facades\Auth::user()->credit }}</div>--}}
{{--        @else--}}
{{--            <div style="--}}
{{--    color: white;background-color: #F4B340 ;--}}
{{--    padding: 5px 25px;    font-weight: 500;--}}
{{--    text-align: center;">{{"Credits - 0"}}</div>--}}
{{--        @endif--}}
{{--        <a style="font-weight: 500;" class="btn btn-success text-white" href="{{route('user-plans')}}">--}}
{{--            Buy SMS Bundles--}}
{{--        </a>--}}
{{--        <a class="btn btn-primary text-white" href="{{route('log-out')}}">--}}
{{--            <span class="fa fa-sign-out"></span>--}}
{{--            Log Out--}}
{{--        </a>--}}
{{--    </div>--}}


</nav>

{{--Nav Bar End--}}
