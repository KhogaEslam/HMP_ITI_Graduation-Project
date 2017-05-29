<!DOCTYPE HTML>
<html>
<head>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.css')}}"/>
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/home.css')}}"/>

    <title> @yield('title')</title>
</head>
<body>

<nav class="navbar navbar-default nav1">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">



            <ul class="nav navbar-nav navbar-right">


                <ul class="nav navbar-nav">
                    <li class="dropdown">

                        @if (Route::has('login'))
                            @if (Auth::check())
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Welcome, {{ Auth::user()->name }}<span class="glyphicon glyphicon-user pull-right"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">My Profile <span class="glyphicon glyphicon-user pull-right"></span></a></li>

                                    <li class="divider"></li>
                                    <li class="divider"></li>

                                    <li><a href="#">Wishlist <span class="glyphicon glyphicon-heart pull-right"></span></a></li>

                                    <li class="divider"></li>
                                    <li class="divider"></li>

                                    <li><a href="#">Settings <span class="glyphicon glyphicon-cog pull-right"></span></a></li>

                                    <li class="divider"></li>
                                    <li class="divider"></li>
                                    <li><a href="#">Messages <span class="badge pull-right"> 42 </span></a></li>
                                    <li class="divider"></li>
                                    <li class="divider"></li>

                                    <li>
                                        <a href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout<span class="glyphicon glyphicon-log-out pull-right"></span>
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>

                                </ul>
                        @else
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Enter<span class="glyphicon glyphicon-user pull-right"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ url('/customer/login') }}">Login<span class="glyphicon glyphicon-log-in pull-right"></span></a></li>
                                    <li><a href="{{ url('/customer/register') }}">Register<span class="glyphicon glyphicon-registration-mark
 pull-right"></span></a></li>
                                </ul>
                        @endif
                    @endif
                    </li>
                </ul>

            </ul>

        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

<nav class="navbar navbar-default nav2 ">

    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="{{url('/')}}"><img class="logo" src="{{ asset('images/logo.png')}}"></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="active"><a href="{{url('/')}}">Home<span class="sr-only">(current)</span></a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">All Ctegories<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        @forelse($categories as $category)
                            <li> {{link_to_action("CustomerController@products", $category->name, [$category])}}</li>
                        @empty
                            <li>No categories yet</li>
                        @endforelse
                    </ul>
                </li>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact</a></li>
            </ul>


            <ul class="nav navbar-nav navbar-right">

                <li><a href="#"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a></li>

                <li>
                    <a href="#">
                        <span class="count" >
                            @if(isset($inCartProducts))
                                {{$inCartProducts}}
                            @else
                                0
                            @endif
                        </span>
                    </a>
                </li>
                <form class="navbar-form navbar-right mySearch">

                    <div class="input-group stylish-input-group">
                        <input type="text" class="form-control"  placeholder="Search" >
                        <span class="input-group-addon">
                        <button type="submit">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                    </span>
                    </div>
                </form>


            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

@yield('content')

<footer>
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-2  col-md-2 col-sm-4 col-xs-6">
                    <h3> Lorem Ipsum </h3>
                    <ul>
                        <li> <a href="#"> Lorem Ipsum </a> </li>
                        <li> <a href="#"> Lorem Ipsum </a> </li>
                        <li> <a href="#"> Lorem Ipsum </a> </li>
                        <li> <a href="#"> Lorem Ipsum </a> </li>
                    </ul>
                </div>
                <div class="col-lg-2  col-md-2 col-sm-4 col-xs-6">
                    <h3> Information </h3>
                    <ul>
                        <li> <a href="#"> Home </a> </li>
                        <li> <a href="#"> All Categories </a> </li>
                        <li> <a href="#"> About </a> </li>
                        <li> <a href="#"> Contact </a> </li>
                    </ul>
                </div>
                <div class="col-lg-2  col-md-2 col-sm-4 col-xs-6">
                    <h3> Lorem Ipsum </h3>
                    <ul>
                        <li> <a href="#"> Lorem Ipsum </a> </li>
                        <li> <a href="#"> Lorem Ipsum </a> </li>
                        <li> <a href="#"> Lorem Ipsum </a> </li>
                        <li> <a href="#"> Lorem Ipsum </a> </li>
                    </ul>
                </div>
                <div class="col-lg-2  col-md-2 col-sm-4 col-xs-6">
                    <h3> Lorem Ipsum </h3>
                    <ul>
                        <li> <a href="#"> Lorem Ipsum </a> </li>
                        <li> <a href="#"> Lorem Ipsum </a> </li>
                        <li> <a href="#"> Lorem Ipsum </a> </li>
                        <li> <a href="#"> Lorem Ipsum </a> </li>
                    </ul>
                </div>
                <div class="col-lg-3  col-md-3 col-sm-6 col-xs-12 ">
                    <h3> Lorem Ipsum </h3>
                    <ul>
                        <li>
                            <div class="input-append newsletter-box text-center">
                                <input type="text" class="full text-center" placeholder="Email ">
                                <button class="btn  bg-gray" type="button"> Lorem ipsum <i class="fa fa-long-arrow-right"> </i> </button>
                            </div>
                        </li>
                    </ul>
                    <ul class="social">
                        <li> <a href="#"> <i class=" fa fa-facebook">   </i> </a> </li>
                        <li> <a href="#"> <i class="fa fa-twitter">   </i> </a> </li>
                        <li> <a href="#"> <i class="fa fa-google-plus">   </i> </a> </li>
                        <li> <a href="#"> <i class="fa fa-pinterest">   </i> </a> </li>
                        <li> <a href="#"> <i class="fa fa-youtube">   </i> </a> </li>
                    </ul>
                </div>
            </div>
            <!--/.row-->
        </div>
        <!--/.container-->
    </div>
    <!--/.footer-->

    <div class="footer-bottom">
        <div class="container">
            <p class="pull-left"> Copyright © Footer E-commerce Plugin 2014. All right reserved. </p>
            <div class="pull-right">
                <ul class="nav nav-pills payments">
                    <li><i class="fa fa-cc-visa"></i></li>
                    <li><i class="fa fa-cc-mastercard"></i></li>
                    <li><i class="fa fa-cc-amex"></i></li>
                    <li><i class="fa fa-cc-paypal"></i></li>
                </ul>
            </div>
        </div>
    </div>
    <!--/.footer-bottom-->
</footer>
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js')}}"></script>
<script src="{{ asset('js/slider.js')}}"></script>

</body>
</html>