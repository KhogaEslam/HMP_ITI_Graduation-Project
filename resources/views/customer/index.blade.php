@extends('layouts.customer')

@section('content')
    <div class="container">
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                <div class="item active"> <img class="myheader" src="images/header.jpg">
                    <div class="carousel-caption">
                        <!--       <h3>Headline</h3>
          <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. </p>--></div>
                </div>
                <!-- End Item -->
                <div class="item"> <img class="myheader" src="images/header.jpg">
                    <div class="carousel-caption">
                        {{--<h3>Headline</h3>--}}
                        <!--<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.  </p>-->
                    </div>
                </div>
                <!-- End Item -->
                <div class="item"> <img class="myheader" src="images/header.jpg">
                    <div class="carousel-caption">
                        <!--       <h3>Headline</h3>
          <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.  </p>--></div>
                </div>
                <!-- End Item -->
                <div class="item"> <img class="myheader" src="images/header.jpg">
                    <div class="carousel-caption">
                        <!-- <h3>Headline</h3>
            <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. </p>--></div>
                </div>
                <!-- End Item -->
            </div>
            <!-- End Carousel Inner -->
            <ul class="nav nav-pills nav-justified" id="pullet">
                <li data-target="#myCarousel" data-slide-to="0" class="active">
                    <a href="#"></a>
                </li>
                <li data-target="#myCarousel" data-slide-to="1">
                    <a href="#"></a>
                </li>
                <li data-target="#myCarousel" data-slide-to="2">
                    <a href="#"></a>
                </li>
                <li data-target="#myCarousel" data-slide-to="3">
                    <a href="#"></a>
                </li>
            </ul>
        </div>
        <!-- End Carousel -->
    </div>
    <button class="myButton shop">Shop Now</button>

    <!--    New Arrivals-->
    <h3>New Arrivals</h3>
    <section class="container">
        <div class="row">
            @foreach($newArrivals as $newProduct)
                <div class="col-lg-3 col-md-3 col-xs-12">
                    <div class="thumbnail">
                        @if(! $newProduct->images()->get()->isEmpty())
                            <a href="{{action("CustomerController@productDetails", [$newProduct->category, $newProduct->id])}}">
                                <center><img  src="{{route("image", [$newProduct->images()->get()->first()->stored_name])}}"  alt="{{$newProduct->name}}"></center>
                            </a>
                        @else
                            <a href="{{action("CustomerController@productDetails", [$newProduct->category, $newProduct->id])}}">
                                <center><img alt="No image provided"></center>
                            </a>
                        @endif
                        <div class="caption">
                            <a href="{{action("CustomerController@productDetails", [$newProduct->category, $newProduct->id])}}">
                                <h4 class="myTitle">{{$newProduct->name}}</h4>
                            </a>
                            <span class="price">{{$newProduct->price}} $</span>
                            <div class="star-rating-container aggregate">
                                <div class="star-rating" title="Rated <?= $newProduct->avg_rate ?> out of 5">
                                    @for ($i=0; $i< $newProduct->avg_rate ; $i++ )
                                    <span class="star filled"> </span>
                                    @endfor
                                    @for ($i= $newProduct->avg_rate; $i < 5; $i++)
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

    <!--Banner-->
    @if($banner->type == 0)
        <a href="category/{{$category}}/products/{{$banner->connected_id}}"><img class="banner" src="{{route("banner", [$banner->image])}}"></a>
    @elseif($banner->type == 1)
        <a href="customer/shop/{{$banner->connected_id}}"><img class="banner" src="{{route("banner", [$banner->image])}}"></a>
    @else
        <img class="banner" src="images/banner.jpg">
    @endif


    <!-- Best Selling  -->
    <h3>Best Selling</h3>
    <section class="container">
        <div class="row">
            @foreach($bestSellings as $bestSelling)
                <div class="col-lg-3 col-md-3 col-xs-12">
                    <div class="thumbnail">
                        @if(! $bestSelling->images()->get()->isEmpty())
                            <a href="{{action("CustomerController@productDetails", [$bestSelling->category, $bestSelling->id])}}">
                                <center><img  width="245" height="158"  src="{{route("image", [$bestSelling->images()->get()->first()->stored_name])}}" class="product1" alt="{{$bestSelling->name}}"></center>
                            </a>
                        @else
                            <a href="{{action("CustomerController@productDetails", [$bestSelling->category, $bestSelling->id])}}">
                                <center><img  width="245" height="158" alt="No image provided"></center>
                            </a>
                        @endif
                        <div class="caption">
                            <a href="{{action("CustomerController@productDetails", [$bestSelling->category, $bestSelling->id])}}">
                                <h4 class="myTitle">{{$bestSelling->name}}</h4>
                            </a>
                            <span class="price">{{$bestSelling->price}} $</span>
                            <div class="star-rating-container aggregate">
                                <div class="star-rating" title="Rated {{ $bestSelling->avg_rate }} out of 5">
                                    @for ($i=0; $i< $bestSelling->avg_rate ; $i++ )
                                        <span class="star filled"> </span>
                                    @endfor
                                    @for ($i= $bestSelling->avg_rate; $i < 5; $i++)
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

    <!-- Featured Items  -->
    <h3>Featured Items</h3>
    <section class="container">
        <div class="row">
            @foreach($featuredProducts as $featuredProduct)
                @if($featuredProduct->product->isPublished())
                    <div class="col-lg-3 col-md-3 col-xs-12">
                        <div class="thumbnail">
                            @if(! $featuredProduct->product->images()->get()->isEmpty())
                                <a href="{{action("CustomerController@productDetails", [$featuredProduct->product->category, $featuredProduct->product])}}">
                                    <center><img  width="245" height="158"  src="{{route("image", [$featuredProduct->product->images()->get()->first()->stored_name])}}" class="product1" alt="{{$featuredProduct->product->name}}"></center>
                                </a>
                            @else
                                <a href="{{action("CustomerController@productDetails", [$featuredProduct->product->category, $featuredProduct->product])}}">
                                    <center><img  width="245" height="158" alt="No image provided"></center>
                                </a>
                            @endif
                            <div class="caption">
                                <a href="{{action("CustomerController@productDetails", [$featuredProduct->product->category, $featuredProduct->product])}}">
                                    <h4 class="myTitle">{{$featuredProduct->product->name}}</h4>
                                </a>
                                <span class="price">{{$featuredProduct->product->price}} $</span>
                                <div class="star-rating-container aggregate">
                                    <div class="star-rating" title="Rated {{$featuredProduct->product->avg_rate }} out of 5">
                                        @for ($i=0; $featuredProduct->avg_rate ; $i++ )
                                            <span class="star filled"> </span>
                                        @endfor
                                        @for ($i= $featuredProduct->avg_rate; $i < 5; $i++)
                                            <span class="star"> </span>
                                        @endfor
                                    </div>
                                </div>
                                <button class="myButton add">Add To Cart</button>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </section>
@endsection
