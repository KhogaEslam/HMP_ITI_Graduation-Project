<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> @yield('title')</title>

    <!-- Styles -->

    <link href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700,400italic" rel="stylesheet">

    {{--<link href="{{ asset('css/docs.css') }}" rel="stylesheet">--}}
    <link href="{{ asset('css/toolkit-light.css')}}" rel="stylesheet">
    <link href="{{ asset('css/application.css') }}" rel="stylesheet">
    <link href="{{asset("css/font-awesome.min.css")}}" rel="stylesheet">


    <link href="{{ asset('css/panel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom-style.css') }}" rel="stylesheet">


    <script src="{{ asset('js/tether.min.js') }} "></script>
{{--    <script src="{{ asset('js/jquery.min.js') }} "></script>--}}
    <script src="{{asset("js/dev.js")}}"></script>

    <style>
        /* note: this is a hack for ios iframe for bootstrap themes shopify page */
        /* this chunk of css is not part of the toolkit :) */
        body {
            width: 1px;
            min-width: 100%;
            *width: 100%;
        }
    </style>
</head>


<body>

{{--<nav class="navbar navbar-default myNav">--}}
    {{--<ul class="nav navbar-nav container">--}}
        {{--<li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Welcome Ahmed <span class="caret"></span></a>--}}
            {{--<form method="POST" action="{{route("logout")}}">--}}
                {{--{!! csrf_field() !!}--}}
                {{--<button type="submit" class="transparent"> Logout </button>--}}
            {{--</form>--}}
        {{--</li>--}}
    {{--</ul>--}}
{{--</nav>--}}
<nav class="navbar navbar-default myNav">
    <ul class="nav navbar-nav container">
        <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Welcome Ahmed <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li>
                    {!! Form::open(["route" => "logout"]) !!}
                        {!! Form::submit("Logout", ["class" => "transparent", "style" => "color: white;"]) !!}
                    {!! Form::close() !!}
                </li>
            </ul>
        </li>
    </ul>
</nav>

{{--<nav class="navbar navbar-default myNav">--}}

    {{--<ul class="nav navbar-nav container">--}}
        {{--<li class="dropdown">--}}
            {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Welcome  <span class="caret"></span></a>--}}
            {{--<ul class="dropdown-menu">--}}
                {{--<li>--}}
                    {{--<form method="POST" action="{{route("logout")}}">--}}
                        {{--{!! csrf_field() !!}--}}
                        {{--<button type="submit" class="btn btn-danger"> Logout </button>--}}
                    {{--</form>--}}
                {{--</li>--}}
            {{--</ul>--}}
        {{--</li>--}}
    {{--</ul>--}}

{{--</nav>--}}
<div class="container">
    <div class="row">
        <div class="col-md-3 sidebar">
            <nav class="sidebar-nav">
                <div class="sidebar-header">
                    <button class="nav-toggler nav-toggler-md sidebar-toggler" type="button" data-toggle="collapse" data-target="#nav-toggleable-md">
                        <span class="sr-only">Toggle nav</span>
                    </button>
                    <a class="sidebar-brand img-responsive" href="/shop">
                        <span class="icon icon-leaf sidebar-brand-icon"><span class="panel-title">Admin Panel </span></span>
                    </a>
                </div>

                <div class="collapse nav-toggleable-md" id="nav-toggleable-md">
                    <form class="sidebar-form">
                        <input class="form-control" type="text" placeholder="Search...">
                        <button type="submit" class="btn-link">
                            <span class="icon icon-magnifying-glass"></span>
                        </button>
                    </form>
                    <ul class="nav nav-pills nav-stacked flex-column">
                        <li class="nav-item">
                            <a class="nav-link dashboard-link" href="{{action("VendorController@index")}}" > Dashboard</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{action("VendorController@addresses")}}">View shop addresses</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{action("VendorController@phones")}}">View shop addresses</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{action("VendorController@addBannerRequest")}}">Request Banner</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{action("VendorController@viewCheckouts")}}">Current orders</a>
                        </li>

                        @role("shop")
                        <li class="nav-item">
                            <a class="nav-link" href="{{action("VendorController@showEmployees")}}">Registered employees</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{action("VendorController@showNewEmployeeForm")}}">Register an employee</a>
                        </li>
                        @endrole

                        <li class="nav-item">
                            <a class="nav-link" href="{{action("VendorController@mostProfitableProducts")}}">Top products</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{action("VendorController@mostSoldProducts")}}">Top sales</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{action("VendorController@mostProfitableCategories")}}">Top categories</a>
                        </li>

                    </ul>
                    <hr class="visible-xs mt-3">
                </div>
            </nav>
        </div>
        <div class="col-md-9 content">
            @yield('content')

        </div>
    </div>
</div>




<script src="{{ asset('js/chart.js') }} "></script>
<script src="{{ asset('js/tablesorter.min.js') }} "></script>
<script src="{{ asset('js/toolkit.js') }} "></script>
<script src="{{ asset('js/panel.js') }} "></script>
<script src="{{ asset('js/custom_script.js') }}"></script>
<<<<<<< HEAD
<script src="{{ asset('js/ajaxRequests.js')}}"></script>

=======
<script src="{{ asset("js/application.js") }}"></script>
>>>>>>> 94fb1db7a107bd5d63e700668342f92553b7a457
<script>
    // execute/clear BS loaders for docs
    $(function(){while(window.BS&&window.BS.loader&&window.BS.loader.length){(window.BS.loader.pop())()}})
</script>
</body>
</html>

