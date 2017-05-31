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

    <link href="{{ asset('css/toolkit-inverse.css')}}" rel="stylesheet">
    <link href="{{asset("css/font-awesome.min.css")}}" rel="stylesheet">


    <link href="{{ asset('css/panel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom-style.css') }}" rel="stylesheet">

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
<nav class="navbar navbar-default myNav">

    <ul class="nav navbar-nav container">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Welcome  <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li>
                    <form method="POST" action="{{route("logout")}}">
                        {!! csrf_field() !!}
                        <button type="submit" class="btn btn-danger"> Logout </button>
                    </form>
                </li>
            </ul>
        </li>
    </ul>

</nav>
<div class="container">
    <div class="row">
        <div class="col-md-3 sidebar">
            <nav class="sidebar-nav">
                <div class="sidebar-header">
                    <button class="nav-toggler nav-toggler-md sidebar-toggler" type="button" data-toggle="collapse" data-target="#nav-toggleable-md">
                        <span class="sr-only">Toggle nav</span>
                    </button>
                    <a class="sidebar-brand img-responsive" href="/admin">
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
                            <a class="nav-link dashboard-link" href="/admin" > Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/categories">Categries</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/banner_requests">Banner Requests</a>
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




<script src="{{ asset('js/jquery.min.js') }} "></script>
<script src="{{ asset('js/tether.min.js') }} "></script>
<script src="{{ asset('js/chart.js') }} "></script>
<script src="{{ asset('js/tablesorter.min.js') }} "></script>
<script src="{{ asset('js/toolkit.js') }} "></script>
<script src="{{ asset('js/panel.js') }} "></script>
<script src="{{ asset('js/custom_script.js') }}"></script>
<script>
    // execute/clear BS loaders for docs
    $(function(){while(window.BS&&window.BS.loader&&window.BS.loader.length){(window.BS.loader.pop())()}})
</script>
</body>
</html>

