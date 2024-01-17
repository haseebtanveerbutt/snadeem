<body>


<nav class="navbar navbar-expand-lg ">
    <div>
        <a style="margin-left: 10px;" class="navbar-brand" href="{{Route('admin.dashboard')}}">
            {{--            <img style="max-height: 65px;" src="{{asset('text-global-uk.jpg')}}">--}}
            Omnie Live Support
        </a>
    </div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse custom-nav-collapse justify-content-center" id="navbarSupportedContent">

        <ul class=" navbar-nav  text-center">
            <li class="nav-item active" style="margin-right: 12px;">
                <a class="nav-link @if(\Request::getPathInfo() == '/admin') active-line @endif" href="{{route('admin.dashboard')}}">Dashboard<span class="sr-only"></span></a>
            </li>
            <li class="nav-item active"  style="margin-right: 12px;">
                <a class="nav-link @if(\Request::getPathInfo() == '/admin/shops') active-line @endif" href="{{route('shops')}}">Shops<span class="sr-only"></span></a>
            </li>
            <li class="nav-item active" style="margin-right: 12px;">
                <a class="nav-link @if(\Request::getPathInfo() == '/admin/orders') active-line @endif" href="{{route('admin.all.orders')}}">Orders<span class="sr-only"></span></a>
            </li>
            <li class="nav-item active" style="margin-right: 12px;">
                <a class="nav-link @if(\Request::getPathInfo() == '/admin/questions') active-line @endif" href="{{route('admin.questions')}}">Questions<span class="sr-only"></span></a>
            </li>
            <li class="nav-item active" style="margin-right: 12px;">
                <a class="nav-link @if(\Request::getPathInfo() == '/admin/email/settings') active-line @endif" href="{{route('admin.email.setting')}}">Email Settings<span class="sr-only"></span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link @if(\Request::getPathInfo() == '/admin/plans') active-line @endif" href="{{route('admin.plans')}}">Plans<span class="sr-only"></span></a>
            </li>
            {{--                <li class="nav-item active">--}}
            {{--                    <a class="nav-link" href="{{route('plans')}}">Bundles<span class="sr-only"></span></a>--}}
            {{--                </li>--}}
            {{--                <li class="nav-item active">--}}
            {{--                    <a class="nav-link" href="{{route('all-contactus')}}">Contact Us<span class="sr-only"></span></a>--}}
            {{--                </li>--}}
            {{--                <li class="nav-item active">--}}
            {{--                    <a class="nav-link" href="{{route('admin-settings')}}">Settings<span class="sr-only"></span></a>--}}
            {{--                </li>--}}
        </ul>

    </div>
    <div class="dropdown" style="min-width: 150px;
    text-align: right;">
        @if(auth()->user()->role == 1)
            <button style="background: #202E78 !important;border-color: #202E78 !important;box-shadow: 0 0 0 0 !important;"
                    class="btn dropdown-toggle text-white btn-primary " type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Admin
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <form action="{{route('logout')}}" method="post">
                    @csrf
                    <button class="dropdown-item"  type="submit">Logout</button>
                </form>
            </div>
        @endif
    </div>
</nav>


{{--Nav Bar End--}}
