@extends('layouts.customer')
@section('title')
    Products
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-xs-12">
                <div class="side-menu">
                    <form name="searchFilterForm" method="get" action="{{action("SearchController@filter")}}" class="navbar-form">
                        <nav class="navbar navbar-default" role="navigation">
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
                                            <div class="navbar-form" role="search">
                                                <div class="form-group">
                                                    <input style="width: 100%" name="name"type="text" class="form-control">
                                                </div>
                                                <button type="button" class="btn btn-default "><span class="glyphicon glyphicon-ok"></span></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Brand and toggle get grouped for better mobile display -->

                            <!-- Main Menu -->
                            <div class="side-menu-container">
                                <ul class="nav navbar-nav">
                                    <li>
                                        <h3> Category</h3>
                                        @foreach($categories as $category)
                                            <div class="checkbox-toolbar">
                                                <label style="color: black;font-weight:normal;vertical-align: middle;padding-top:4px;">
                                                    <input  style="vertical-align: middle" class="form-control" type="checkbox" name="cat_name[]" value="{{$category->name}}"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i>
                                                     {{$category->name}}
                                                </label>
                                            </div>
                                        @endforeach
                                    </li>
                                    <li>
                                        <h3> Min. Price</h3>
                                        <div class="range">
                                            <input type="range" value="{{$maxPrice/2}}" class="form-control" name="price" min="1" max="{{$maxPrice}}"  onchange="range.value='$ ' + value">
                                            <output id="range">$ {{$maxPrice/2}}</output>
                                        </div>
                                    </li>
                                    <li>
                                        <h3> Avg. customer review</h3>
                                        <div  class="radio-toolbar">
                                            <label>
                                                <input  type="radio" name="rate" value = "4"> <i class="fa fa-circle-o fa-2x"></i><i class="fa fa-dot-circle-o fa-2x"></i>  <img style="width:120px;margin-right: 20px" src="{{ asset('images/stars 4.png')}}"> & up
                                            </label>
                                        </div>
                                        <div  class="radio-toolbar">
                                            <label>
                                                <input  type="radio" name="rate" value = "3"> <i class="fa fa-circle-o fa-2x"></i><i class="fa fa-dot-circle-o fa-2x"></i>  <img style="width:120px;margin-right: 20px" src="{{ asset('images/stars 3.png')}}"> & up
                                            </label>
                                        </div>
                                        <div  class="radio-toolbar">
                                            <label>
                                                <input type="radio" name="rate" value = "2"> <i class="fa fa-circle-o fa-2x"></i><i class="fa fa-dot-circle-o fa-2x"></i>  <img style="width:120px;margin-right: 20px" src="{{ asset('images/stars 2.png')}}"> & up
                                            </label>
                                        </div>
                                        <div class="radio-toolbar">
                                            <label>
                                                <input  type="radio" name="rate" value = "1"> <i class="fa fa-circle-o fa-2x"></i><i class="fa fa-dot-circle-o fa-2x"></i>  <img style="width:120px;margin-right: 20px;" src="{{ asset('images/stars 1.png')}}"> & up
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <button style="display:block; margin-top:10px;width:100%" type="submit" class="btn myButton">Search </button>
                                    </li>
                                </ul>

                            </div>
                            </form>
                        </nav>
                    </div>
                </div>


            <section class="container col-md-9 col-xs-12 main">
                <div class="row">
                    <div class="col-md-12">
                        <h1> {{$pageHeading}} </h1>
                    </div>
                </div>
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
                                    <span class="price">{{$product->price}} $</span>
                                    <div class="star-rating-container aggregate">
                                        <div class="star-rating" title="Rated {{ $product->avg_rate }} out of 5">
                                            @for ($i=0; $i< $product->avg_rate ; $i++ )
                                                <span class="star filled"> </span>
                                            @endfor
                                            @for ($i= $product->avg_rate; $i < 5; $i++)
                                                <span class="star"> </span>
                                            @endfor
                                        </div>
                                    </div>
                                    <button class="myButton add">Add To Cart</button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <h1 class="text-danger text-center">{{$zeroResult}}</h1>
                    @endforelse
                </div>
            </section>
        </div>
    </div>

@endsection