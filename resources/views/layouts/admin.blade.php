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

    <script src="{{URL::to('js/tinymce/tinymce.min.js')}}"></script>
    <script>
        var editor_config = {
            path_absolute : "{{ URL::to('/') }}/",
            selector : "textarea",
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor colorpicker textpattern"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
            relative_urls: false,
            file_browser_callback : function(field_name, url, type, win) {
                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementByTagName('body')[0].clientWidth;
                var y = window.innerHeight|| document.documentElement.clientHeight|| document.grtElementByTagName('body')[0].clientHeight;
                var cmsURL = editor_config.path_absolute+'laravel-filemanaget?field_name'+field_name;
                if (type = 'image') {
                    cmsURL = cmsURL+'&type=Images';
                } else {
                    cmsUrl = cmsURL+'&type=Files';
                }

                tinyMCE.activeEditor.windowManager.open({
                    file : cmsURL,
                    title : 'Filemanager',
                    width : x * 0.8,
                    height : y * 0.8,
                    resizeble : 'yes',
                    close_previous : 'no'
                });
            }
        };

        tinymce.init(editor_config);
    </script>

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
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Welcome {{ Auth::user()->name }}<span class="caret"></span></a>
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
                            <a class="nav-link" href="/admin/categories">Categories</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/users">Users</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/registration-requests">Registration Requests</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/category-requests">Category Requests</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/banner_requests">Banner Requests</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="/admin/featured_requests">Feature Request</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="/admin/about/show">About Page</a>
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

