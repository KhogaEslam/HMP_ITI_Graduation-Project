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

            <div class="product">

                <img class="product1" src="images/cam.jpg">
                <h4 class="myTitle">Canon EOS 1200D</h4>
                <span class="price">5290 LE</span>
                <img class="rate" src="images/stars%20(2).png">
                <button class="myButton add">Add To Cart</button>
            </div>


            <div class="product">

                <img class="product1" src="images/laptop.jpg">
                <h4 class="myTitle">Lenovo Ideapad 300</h4>
                <span class="price">6550 LE</span>
                <img class="rate" src="images/stars%20(2).png">



                <button class="myButton add">Add To Cart</button>
            </div>

            <div class="product">

                <img class="product1" src="images/mobile.jpg">
                <h4 class="myTitle">Lenovo TAB 2 A7-30 Tablet</h4>
                <span class="price">1480 LE</span>
                <img class="rate" src="images/stars%20(2).png">


                <button class="myButton add">Add To Cart</button>
            </div>

            <div class="product">

                <img class="product1" src="images/tablet2.jpg">
                <h4 class="myTitle">Innjoo F4 Pro Dual Sim</h4>
                <span class="price">1589 LE</span>
                <img class="rate" src="images/stars%20(2).png">

                <button class="myButton add">Add To Cart</button>
            </div>
        </div>
    </div>


    <img class="banner" src="images/banner.jpg">

    <!-- Featured Items  -->
    <h3>Featured Items</h3>

    <div class="row">
        <div class="allProducts container">
            <div class="product">

                <img class="product1" src="images/cam.jpg">
                <h4 class="myTitle">Canon EOS 1200D</h4>
                <span class="price">5290 LE</span>
                <img class="rate" src="images/stars%20(2).png">

                <button class="myButton add">Add To Cart</button>
            </div>

            <div class="product">

                <img class="product1" src="images/laptop.jpg">
                <h4 class="myTitle">Lenovo Ideapad 300</h4>
                <span class="price">6550 LE</span>
                <img class="rate" src="images/stars%20(2).png">



                <button class="myButton add">Add To Cart</button>
            </div>

            <div class="product">

                <img class="product1" src="images/mobile.jpg">
                <h4 class="myTitle">Lenovo TAB 2 A7-30 Tablet</h4>
                <span class="price">1480 LE</span>
                <img class="rate" src="images/stars%20(2).png">

                <button class="myButton add">Add To Cart</button>
            </div>

            <div class="product">

                <img class="product1" src="images/tablet2.jpg">
                <h4 class="myTitle">Innjoo F4 Pro Dual Sim</h4>
                <span class="price">1589 LE</span>
                <img class="rate" src="images/stars%20(2).png">


                <button class="myButton add">Add To Cart</button>
            </div>
        </div>
    </div>
@endsection