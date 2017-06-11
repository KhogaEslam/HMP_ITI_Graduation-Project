@extends('layouts.customer')

@section('content')
    {{-- facebook share --}}
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.9&appId=421062961593419";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>

    {{-- product details --}}
    <div class="row">
        <div class="container single">
            <div class="col-md-8 col-sm-12">
                <div class="col-xs-2 single-pro">
                    @foreach($product->images as $image)
                        <div class="thumbnail proImg"><img class="bigger" src="{{route("image", [$image->stored_name])}}"></div>
                    @endforeach
                </div>
                <div class="col-xs-10 ">
                    @if(! $product->images()->get()->isEmpty())
                        <div class="thumbnail originalImg"><img class="bigger" src="{{route("image", [$product->images()->get()->first()->stored_name])}}"></div>
                    @else
                        <img alt="No image provided" class="bigger">
                    @endif
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <h3>{{$product->name}}</h3>
                <div class=" star-rating-container aggregate">
                    <div class="rate2 star-rating" title="Rated {{ $product->avg_rate }} out of 5">
                        @for ($i=0; $i< $product->avg_rate ; $i++ )
                            <span class="star filled"></span>
                        @endfor
                        @for ($i= $product->avg_rate; $i < 5; $i++)
                            <span class="star"></span>
                        @endfor
                    </div>
                </div>
                <p>

                    @if($product->discount + $product->offer > 0)
                        <span class="item_price">{{$product->price - $product->discount / 100.0 * $product->price -  $product->offer / 100.0 * $product->price}}$ &nbsp;&nbsp;</span>
                        <del>{{$product->price}} $</del>
                    @else
                        <span class="item_price">{{$product->price}} $ &nbsp;&nbsp;</span>
                    @endif
                </p>

                @role("customer")
                @if($product->ratings->where('user_id','=' , \Auth::user()->id )->isEmpty())
                    <div class="stars">
                        <h4>Rate this product</h4>
                        <form id= "ratingForm" method='post' action="{{action("CustomerController@submitRating", [$product])}}">
                                <input class="star star-5" id="star-5" value="5" type="radio" name="star"/>
                                <label class="star star-5" for="star-5"></label>
                                <input class="star star-4" value="4" id="star-4" type="radio" name="star"/>
                                <label class="star star-4" for="star-4"></label>
                                <input class="star star-3" value="3" id="star-3" type="radio" name="star"/>
                                <label class="star star-3" for="star-3"></label>
                                <input class="star star-2" value="2" id="star-2" type="radio" name="star"/>
                                <label class="star star-2" for="star-2"></label>
                                <input class="star star-1" value="1" id="star-1" type="radio" name="star"/>
                                <label class="star star-1" for="star-1"></label>

                            <div class="form-group">
                                <button disabled="true" type="submit" class="add-rating btn btn-primary"> Submit rating</button>
                            </div>
                        </form>
                    </div>
                    <div id="ratingAjaxResponse" style="height:80px;display: none;"></div>
                @endif
                @endrole


                <h4 style="margin-top: 20px">Category</h4> <span>{{$category->name}}</span>
                <div class="description">
                    <h4>Description</h4>
                    <p>{{$product->description}}</p>
                </div>

                <h4 style="margin-top: 20px">Sold by</h4>
                <span><a href="/vendor/{{$product->user_id}}">{{$soldBy}}</a></span>


                {{-- facebook share --}}
                <br>
                <div class="fb-share-button" data-href="{{ urlencode(request()->fullUrl()) }}" data-layout="button_count" data-size="large" data-mobile-iframe="true">
                    <a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}">Share</a>
                </div>

                @role("customer")
                @if(!isset($isWish))
                    <form style="height:80px" id="add-to-wishlist" action="/customer/{{$product->id}}/wishlist/add">
                        <button type="submit" class="myButton wishlist">
                        <span class="glyphicon glyphicon-heart">

                        </span>Add to wishlist
                        </button>
                    </form>
                    <div style="height: 80px; display:none;" id ="wishListAjaxResponse"></div>
                @endif
                @if(\Auth::user()->cart->cartDetails()->quantity($product->id)->get()->isEmpty())
                    <button class="myButton add" data-toggle="modal" data-target="#addModal">Add To Cart</button>

                    <div class="modal fade" id="addModal" role="dialog">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Add To Cart</h4>
                                </div>
                                {!! Form::open(["action" => ["CustomerController@addToCart", $product], 'class' => 'add-to-cart']) !!}
                                <div class="modal-body">
                                    <div class="form-group">
                                        {!! Form::label("Quantity") !!}
                                        {!! Form::number("quantity", null, ["class" => "form-control cart-quantity" , "min" => 1 , "max" => $product->quantity]) !!}
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    {!! Form::submit("Add to cart",["class" => "btn btn-default modalb"]) !!}
                                    <button type="button" class="btn btn-default modal-close" data-dismiss="modal">Close</button>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                @else
                    <button class="myButton add" data-toggle="modal" data-target="#editModal">Edit Cart</button>

                    <div class="modal fade" id="editModal" role="dialog">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Add To Cart</h4>
                                </div>
                                {!! Form::open(["action" => ["CustomerController@editCart", \Auth::user()->cart->cartDetails()->quantity($product->id)->first()], 'class' => 'edit-cart']) !!}
                                <div class="modal-body">
                                    <div class="form-group">
                                        {!! Form::label("Quantity") !!}
                                        {!! Form::number("quantity", \Auth::user()->cart->cartDetails()->quantity($product->id)->first()->quantity, ["class" => "form-control cart-quantity",  "min" => 1 , "max" => $product->quantity]) !!}
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    {!! Form::submit("Edit cart",["class" => "btn btn-default modalb"]) !!}
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                @endif

                @endrole
                @if(! \Auth::check())
                    <button class="myButton add" data-toggle="modal" data-target="#addModal">Add To Cart</button>

                    <div class="modal fade" id="addModal" role="dialog">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Add To Cart</h4>
                                </div>
                                {!! Form::open(["action" => ["CustomerController@addToGuestCart", $product], "class" => 'add-to-guest-cart']) !!}
                                <div class="modal-body">
                                    <div class="form-group">
                                        {!! Form::label("Quantity") !!}
                                        {!! Form::number("quantity", null, ["class" => "form-control" , "min" => 1 , "max" => $product->quantity]) !!}
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    {!! Form::submit("Add to cart",["class" => "btn btn-default modalb"]) !!}
                                    <button type="button" class="btn btn-default modal-close" data-dismiss="modal">Close</button>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $('.star').change(function () {
                $('.add-rating').removeAttr('disabled');
            });
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $('#ratingForm').on('submit', function(e) {
                e.preventDefault();
                var rating = $('.star:checked').val();
                $.ajax({
                    type: "POST",
                    url: '/customer/{{$product->id}}/rating/add',
                    data: {"star": rating},
                    datatype: 'JSON',
                    success: function(response) {
                        $('.stars').remove();
                        $('#ratingAjaxResponse').show().append('<div class="alert alert-success">' + response.msg + '</div>');
                        $('.star-rating-container').empty();
                        $('.star-rating-container').append('<div class="rate2 star-rating" title="Rated '+ response.rating +' out of 5"></div>')
                        for (var i =0 ; i< response.rating; i++) {
                            $('.star-rating').append('<span class="star filled"></span>')
                        }
                        for (var i = response.rating; i<5; i++) {
                            $('.star-rating').append('<span class="star"></span>')
                        }

                    },
                    error: function() {
                        alert('error')
                    }
                });
            });
            $('#add-to-wishlist').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: "GET",
                    url: '/customer/{{$product->id}}/wishlist/add',
                    datatype: 'JSON',
                    success: function (response) {
                        $('#add-to-wishlist').remove();
                        $('#wishListAjaxResponse').show().append('<div class="alert alert-success">' + response.msg + '</div>');
                    },
                    error: function (jqXHR, exception) {
                        var msg = '';
                        if (jqXHR.status === 0) {
                            msg = 'Not connect.\n Verify Network.';
                        } else if (jqXHR.status == 404) {
                            msg = 'Requested page not found. [404]';
                        } else if (jqXHR.status == 500) {
                            msg = 'Internal Server Error [500].';
                        } else if (exception === 'parsererror') {
                            msg = 'Requested JSON parse failed.';
                        } else if (exception === 'timeout') {
                            msg = 'Time out error.';
                        } else if (exception === 'abort') {
                            msg = 'Ajax request aborted.';
                        } else {
                            msg = 'Uncaught Error.\n' + jqXHR.responseText;
                        }
                         console.log(msg)
                         alert('error')
                    }

                })
            });
            $('.add-to-cart').on('submit', function(e){
                e.preventDefault();
                var quantity  = $('.cart-quantity').val()
                $.ajax({
                    type: 'POST',
                    url: '/customer/{{$product->id}}/add_to_cart',
                    data: {"quantity" : quantity},
                    datatype: 'JSON',
                    success: function(response) {
                        if (response.status == "success") {
                            $('.x-cart-notification').addClass('bring-forward appear loading');
                            $('.modal-close').click();
                            setTimeout(function () {
                                $('.x-cart-notification').addClass('added');
                            }, 1400)
                            setTimeout(function () {
                                $('.x-cart-notification').removeClass('bring-forward appear loading added');
                                $('.incart-quantity').html(response.inCart)
                            }, 2800)
                        }
                        else {
                            $('.modal-close').click();
                            alert (response.msg)
                        }

                    },
                    error: function(response){
                        alert(response.msg)
                    }
                })
            })
        })
    </script>

    <script src="https://code.jquery.com/jquery-2.2.0.min.js"></script>

    {{-- facebook share --}}
    <script>

        var popupSize = {
            width: 780,
            height: 550
        };

        $(document).on('click', '.social-buttons > a', function(e){

            var
                verticalPos = Math.floor(($(window).width() - popupSize.width) / 2),
                horisontalPos = Math.floor(($(window).height() - popupSize.height) / 2);

            var popup = window.open($(this).prop('href'), 'social',
                'width='+popupSize.width+',height='+popupSize.height+
                ',left='+verticalPos+',top='+horisontalPos+
                ',location=0,menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1');

            if (popup) {
                popup.focus();
                e.preventDefault();
            }

        });
    </script>


@include('laravelLikeComment::comment', ['comment_item_id' => $product->id])
    <div class="x-cart-notification">
        <div class="x-cart-notification-icon loading">
            <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
        </div>
        <div class="x-cart-notification-icon added">
            <i class="fa fa-check" aria-hidden="true"></i>
        </div>
    </div>

@endsection
