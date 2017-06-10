@extends('layouts.customer')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-xs-12">
                <div class="side-menu">
                    <nav class="navbar navbar-default" role="navigation">
                        <!-- Main Menu -->
                        <div class="side-menu-container">
                            <ul class="nav navbar-nav">
                                <li><a class="vname">{{$vendor->name}}</a>
                                <p>
                                    {{$vendor->email}}
                                </p>
                                </li>

                                <li><a>
                                        <span class="glyphicon glyphicon-phone"></span>
                                        Phone Numbers
                                    </a>
                                    <p>
                                        @foreach($vendorPhones as $vendorPhone)
                                            {{$vendorPhone->number}}
                                            <br>
                                        @endforeach
                                    </p>
                                </li>
                                <li><a><span class="glyphicon glyphicon-map-marker"></span>
                                        Adersses
                                    </a>
                                    <p>
                                        @foreach($vendorAddresses as $vendorAddress)
                                        {{$vendorAddress->address}}
                                        <br>
                                        @endforeach
                                    </p>
                                </li>
                                <!-- Dropdown-->
                                <li class="panel panel-default" id="dropdown">
                                    <a data-toggle="collapse" href="#dropdown-lvl1"> Categories<span
                                                class="caret"></span> </a>
                                    <!-- Dropdown level 1 -->
                                    <div id="dropdown-lvl1" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <ul class="nav navbar-nav">
                                                @foreach($vendorProducts as $vendorProduct)
                                                    <li><a href="#">{{$vendorProduct->category->name}}</a></li>
                                                @endforeach
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
                    @foreach($vendorProducts as $vendorProduct)
                        <div class="col-md-4 col-xs-12">
                            <div class="thumbnail">
                                @if(! $vendorProduct->images()->get()->isEmpty())
                                    <a href="{{action("CustomerController@productDetails", [$vendorProduct->category, $vendorProduct->id])}}">
                                        <center><img width="245" height="158"
                                                     src="{{route("image", [$vendorProduct->images()->get()->first()->stored_name])}}"
                                                     class="product1" alt="{{$vendorProduct->name}}"></center>
                                    </a>
                                @else
                                    <a href="{{action("CustomerController@productDetails", [$bestSelling->category, $vendorProduct->id])}}">
                                        <center><img width="245" height="158" alt="No image provided"></center>
                                    </a>
                                @endif
                                <div class="caption">
                                    <h4 class="myTitle">{{$vendorProduct->name}}</h4> <span class="price">{{$vendorProduct->price}}
                                        $</span>

                                    <div class="star-rating-container aggregate">
                                        <div class="star-rating" title="Rated {{ $vendorProduct->avg_rate }} out of 5">
                                            @for ($i=0; $i< $vendorProduct->avg_rate ; $i++ )
                                                <span class="star filled"> </span>
                                            @endfor
                                            @for ($i= $vendorProduct->avg_rate; $i < 5; $i++)
                                                <span class="star"> </span>
                                            @endfor
                                        </div>
                                    </div>

                                    <button class="myButton add">Add To Cart</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>
    </div>

@endsection