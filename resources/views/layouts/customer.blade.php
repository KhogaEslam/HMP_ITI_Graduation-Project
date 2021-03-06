<!DOCTYPE HTML>
<html>
<head>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.css')}}"/>
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/home.css')}}"/>
    <link rel="stylesheet" href="{{ asset("css/search.css") }}" />

    <link rel="stylesheet" href="{{ asset("css/icon.min.css") }}" />
    <link rel="stylesheet" href="{{ asset("css/form.min.css") }}" />
    <link rel="stylesheet" href="{{ asset("css/button.min.css") }}" />

    <link href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.2/components/icon.min.css" rel="stylesheet">
    <link href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.2/components/comment.min.css" rel="stylesheet">
    <link href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.2/components/form.min.css" rel="stylesheet">
    <link href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.2/components/button.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset("css/like_and_comment.css") }}" />
    <script src="{{ asset('js/jquery.min.js') }}"></script>



    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
    {!! Twitter::generate() !!}

    <title> @yield('title')</title>
</head>
<body>

<div class="row  nav1">
    <div class="container">
        <ul>
            <ul>
                <li class="dropdown welcome">
                    @if (Route::has('login'))
                        @if (Auth::check())
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Welcome, {{ Auth::user()->name }}<span class="glyphicon glyphicon-user"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="/home">My Profile <span class="glyphicon glyphicon-user pull-right"></span></a></li>

                                <li class="divider"></li>
                                <li class="divider"></li>
                                @role('customer')

                                <li><a href="/customer/wishlist/show">Wishlist <span class="glyphicon glyphicon-heart pull-right"></span></a></li>

                                <li class="divider"></li>
                                <li class="divider"></li>
                                @endrole

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
                                <li><a href="{{ url('/customer/register') }}">Register<span class="glyphicon glyphicon-registration-mark pull-right"></span></a></li>


                                <li class="divider"></li>
                                <li class="divider"></li>
                                <li><a href="{{ url('/shop/register') }}">Register as Vendor<span class="glyphicon pull-right"></span></a></li>
                            </ul>
                        @endif
                    @endif

                </li>
            </ul>
        </ul>
    </div>
</div>
<nav class="navbar navbar-default nav2 ">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span>
                <span class="icon-bar"></span> </button>
            <a href="{{url('/')}}"><img class="logo" src="{{ asset('images/logo.png')}}"></a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="active"><a href="{{url('/')}}">Home <span class="sr-only">(current)</span></a></li>
                <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">All Categories<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        @forelse($categories as $category)
                            <li> {{link_to_action("CustomerController@catProducts", $category->name, [$category])}}</li>
                        @empty
                            <li style="color:red;">No categories yet</li>
                        @endforelse
                    </ul>
                </li>
                <li><a href="/about">About</a></li>
                <li><a href="/contactUs">Contact</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li>
                    @role("customer")
                        <a href="{{action("CustomerController@viewCart")}}"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span class="count" >
                    @endrole

                    @if(!\Auth::check() || !\Auth::user()->hasRole("customer"))
                                    <a href="{{action("CustomerController@viewGuestCart")}}"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span class="count" >
                    @endif
                    @if(isset($inCart))
                         <span class="incart-quantity"> {{$inCart}} </span>
                    @else
                        0
                    @endif</span></a></li>
                <form class="navbar-form navbar-right mySearch search" action="{{action("CustomerController@search")}}" method="get">
                    <div class="input-group stylish-input-group">
                        <input name="search_name" type="text" class="form-control"  placeholder="Search" >
                        <span class="input-group-addon">
                            <button type="submit">
                                <span class="glyphicon glyphicon-search"></span>
                            </button>
                        </span>
                        <ul class="results" style="display: none;" >

                        </ul>
                    </div>
                </form>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>

<div class="wrapper">
@yield('content')
</div>
<footer class="panel-footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <ul>
                    <li><img class="logo2" src="{{ asset('images/logo_footer.png')}}"></li>
                    <li>
                        <h5>Where you find Gadgets
                            that suits your needs.</h5> </li>
                    <li>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy.</p>
                    </li>
                </ul>
            </div>
            <div class="col-sm-3">
                <ul class="info">
                    <h2>Information</h2>
                    <li><a style="color: white;" href="{{action("CustomerController@index")}}">Home</a></li>
                    <li><a style="color: white;" href="{{action("CustomerController@showAbout")}}">About</a></li>
                    <li><a style="color: white;" href="{{action("CustomerController@showContactUs")}}">Contact us</a></li>
                </ul>
            </div>
            <div class="col-sm-3">
                <ul>
                    <li>
                        <h2>Follow Us</h2></li>
                    <ul class="social">
                        <li class="k"><a href="#" class="icoFacebook" title="Facebook"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#" class="icoTwitter" title="Twitter"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#" class="icoGoogle" title="Google +"><i class="fa fa-google-plus"></i></a></li>
                    </ul>
                </ul>
            </div>
            <div class="col-sm-3">
                <ul>
                    <li>
                        <h2>Terms of Use</h2></li>
                    <p>Gadgetly. local is the sole owner of information collected on this site. We will not sell, share, or rent this information to any outside parties, except as outlined in this policy....</p>
                </ul>
            </div>
        </div>
    </div>
</footer>

<script src="{{ asset('js/bootstrap.js')}}"></script>
<script src="{{ asset('js/slider.js')}}"></script>
<script src="{{ asset('js/search.js') }}"></script>
<script src="{{ asset('/vendor/laravelLikeComment/js/script.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/ajaxRequests.js')}}"></script>

</body>
</html>