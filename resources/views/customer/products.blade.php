@extends('layouts.customer')
@section('title')
    Products
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-xs-12">
                <div class="side-menu">
                    <nav class="navbar navbar-default" role="navigation">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">
                            <div class="brand-wrapper">
                                <!-- Hamburger -->
                                <button type="button" class="navbar-toggle"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                                <!-- Brand -->
                                <div class="brand-name-wrapper"> <a class="navbar-brand" href="#">
                                        Brand
                                    </a> </div>
                                <!-- Search -->
                                <a data-toggle="collapse" href="#search" class="btn btn-default" id="search-trigger"> <span class="glyphicon glyphicon-search"></span> </a>
                                <!-- Search body -->
                                <div id="search" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <form class="navbar-form" role="search">
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="Search"> </div>
                                            <button type="submit" class="btn btn-default "><span class="glyphicon glyphicon-ok"></span></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Main Menu -->
                        <div class="side-menu-container">
                            <ul class="nav navbar-nav">
                                <li><a href="#">Category</a></li>
                                <li>
                                    <a href="#">
                                        <input type="checkbox" name="mobile" checked> Mobiles</a>
                                </li>
                                <li><a href="#"> Price</a></li>
                                <div class="range">
                                    <input type="range" name="range" min="1" max="1000" value="200" onchange="range.value=value">
                                    <output id="range">50</output>
                                </div>
                                <li><a href="#">Color</a></li>
                                <li>
                                    <a href="#">
                                        <input type="checkbox" name="mobile"> Black
                                        <br>
                                        <input type="checkbox" name="mobile"> White </a>
                                </li>
                                <li><a href="#">System type</a></li>
                                <li>
                                    <a href="#">
                                        <input type="checkbox" name="mobile"> Android
                                        <br>
                                        <input type="checkbox" name="mobile"> Ios </a>
                                </li>
                                <li class="active"><a href="#"><span class="glyphicon glyphicon-plane"></span> Active Link</a></li>
                                <li><a href="#"><span class="glyphicon glyphicon-cloud"></span> Link</a></li>
                                <!-- Dropdown-->
                                <li class="panel panel-default" id="dropdown">
                                    <a data-toggle="collapse" href="#dropdown-lvl1"> <span class="glyphicon glyphicon-user"></span> Sub Level <span class="caret"></span> </a>
                                    <!-- Dropdown level 1 -->
                                    <div id="dropdown-lvl1" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <ul class="nav navbar-nav">
                                                <li><a href="#">Link</a></li>
                                                <li><a href="#">Link</a></li>
                                                <li><a href="#">Link</a></li>
                                                <!-- Dropdown level 2 -->
                                                <li class="panel panel-default" id="dropdown">
                                                    <a data-toggle="collapse" href="#dropdown-lvl2"> <span class="glyphicon glyphicon-off"></span> Sub Level <span class="caret"></span> </a>
                                                    <div id="dropdown-lvl2" class="panel-collapse collapse">
                                                        <div class="panel-body">
                                                            <ul class="nav navbar-nav">
                                                                <li><a href="#">Link</a></li>
                                                                <li><a href="#">Link</a></li>
                                                                <li><a href="#">Link</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <!-- /.navbar-collapse -->
                    </nav>
                </div>
            </div>


            <section class="container col-md-9 col-xs-12 main">
                <div class="row">
                    @forelse($products as $product)
                        <div class="col-md-4 col-xs-12">
                            <div class="thumbnail">
                                @if(! $product->images()->get()->isEmpty())
                                    <a href="{{action("CustomerController@productDetails", [$category->id, $product->id])}}">
                                        <img src="{{route("image", [$product->images()->get()->first()->stored_name])}}" class="img-responsive img-fluid img-rounded" width="235" height="235" alt="No image provided">
                                    </a>
                                @else
                                    <img alt="No image provided">
                                @endif
                                <div class="caption">
                                    <a class="text-warning" href="{{action("CustomerController@productDetails", [$category->id, $product->id])}}">
                                        <h4 class="myTitle">{{$product->name}}</h4>
                                    </a>
                                    <span class="price">{{$product->price}} LE</span>
                                    <img class="rate" src="{{ asset('images/stars.png')}}">
                                    <button class="myButton add">Add To Cart</button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <h1 class="text-danger text-center">No products yet</h1>
                    @endforelse
                </div>
            </section>
        </div>
    </div>

@endsection