@extends('layouts.customer')
@section('title')
    Index
@endsection
@section('content')

    <div class="container">
        <div id="myCarousel" class="carousel slide" data-ride="carousel">

            <!-- Wrapper for slides -->
            <div class="carousel-inner">

                <div class="item active">
                    <img class="myheader" src="images/header.jpg">
                    <div class="carousel-caption">
                        <!--       <h3>Headline</h3>
                           <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. </p>-->
                    </div>
                </div><!-- End Item -->

                <div class="item">
                    <img class="myheader" src="images/header.jpg">
                    <div class="carousel-caption">
                        <h3>Headline</h3>
                        <!--            <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.  </p>-->
                    </div>
                </div><!-- End Item -->

                <div class="item">
                    <img class="myheader" src="images/header.jpg">
                    <div class="carousel-caption">
                        <!--       <h3>Headline</h3>
                           <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.  </p>-->
                    </div>
                </div><!-- End Item -->

                <div class="item">
                    <img class="myheader" src="images/header.jpg">
                    <div class="carousel-caption">
                        <!-- <h3>Headline</h3>
                         <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. </p>-->
                    </div>
                </div><!-- End Item -->

            </div><!-- End Carousel Inner -->


            <ul class="nav nav-pills nav-justified" id="pullet">
                <li data-target="#myCarousel" data-slide-to="0" class="active"><a href="#"></a></li>
                <li data-target="#myCarousel" data-slide-to="1"><a href="#"></a></li>
                <li data-target="#myCarousel" data-slide-to="2"><a href="#"></a></li>
                <li data-target="#myCarousel" data-slide-to="3"><a href="#"></a></li>
            </ul>

        </div><!-- End Carousel -->
    </div>



    <button class="myButton shop">Shop Now</button>




    <!--    New Arrivals-->
    <h3>New Arrivals</h3>
    <div class="row">
        <div class="allProducts container">

            @foreach($newArrivals as $newProduct)
                <div class="product">
                    @if(! $newProduct->images()->get()->isEmpty())
                        <center><img  width="245" height="158"  src="{{route("image", [$newProduct->images()->get()->first()->stored_name])}}" class="product1" alt="{{$newProduct->name}}"></center>
                    @else
                        <center><img  width="245" height="158" alt="No image provided"></center>
                    @endif
                    <h4 class="myTitle">{{$newProduct->name}}</h4>
                    <span class="price">{{$newProduct->price}} LE</span>
                    <img class="rate" src="images/stars.png">
                    <button class="myButton add">Add To Cart</button>
                </div>
            @endforeach

        </div>
    </div>


    <img class="banner" src="images/banner.jpg">

    <!-- Best Selling  -->
    <h3>Best Selling</h3>

    <div class="row">
        <div class="allProducts container">
            @foreach($bestSellings as $bestSelling)
                <div class="product">
                    @if(! $bestSelling->images()->get()->isEmpty())
                        <center><img  width="245" height="158"  src="{{route("image", [$bestSelling->images()->get()->first()->stored_name])}}" class="product1" alt="{{$bestSelling->name}}"></center>
                    @else
                        <center><img  width="245" height="158" alt="No image provided"></center>
                    @endif
                    <h4 class="myTitle">{{$bestSelling->name}}</h4>
                    <span class="price">{{$bestSelling->price}} LE</span>
                    <img class="rate" src="images/stars.png">
                    <button class="myButton add">Add To Cart</button>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Featured Items  -->
    <h3>Featured Items</h3>
    <div class="row">
        <div class="allProducts container">
            @foreach($featuredProducts as $featuredProduct)
                @if($featuredProduct->product->isPublished())
                    <div class="product">
                        @if(! $featuredProduct->product->images()->get()->isEmpty())
                            <center><img  width="245" height="158"  src="{{route("image", [$featuredProduct->product->images()->get()->first()->stored_name])}}" class="product1" alt="{{$featuredProduct->product->name}}"></center>
                        @else
                            <center><img  width="245" height="158" alt="No image provided"></center>
                        @endif
                        <h4 class="myTitle">{{$featuredProduct->product->name}}</h4>
                        <span class="price">{{$featuredProduct->product->price}} LE</span>
                        <img class="rate" src="images/stars.png">
                        <button class="myButton add">Add To Cart</button>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endsection