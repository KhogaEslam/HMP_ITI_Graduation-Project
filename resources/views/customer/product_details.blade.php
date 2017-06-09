@extends('layouts.customer')
@section('title')
    Product
@endsection
@section('content')
    {{-- product details --}}
    <div class="row">
        <div class="container single">
            <div class="col-md-8 col-sm-12">
                <div class="col-xs-2 single-pro">
                    <div class=" thumbnail proImg"><img class="bigger" src="images/e2.png"></div>
                    <div class="thumbnail proImg"><img class="bigger" src="images/e3.png"></div>
                    <div class="thumbnail proImg"><img class="bigger" src="images/e4.png"></div>
                </div>
                <div class="col-xs-10 ">
                    @if(! $product->images()->get()->isEmpty())
                        <div class="thumbnail originalImg"><img class="bigger" src="{{route("image", [$product->images()->get()->first()->stored_name])}}"></div>

                    @else
                        <img alt="No image provided">
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
                    <div id="ajaxResponse" style="height:80px;"></div>
                @endif
                @endrole


                <h4>Category</h4> <span>{{$category->name}}</span>
                <div class="description">
                    <h4>Description</h4>
                    <p>{{$product->description}}</p>
                </div>
                @if(!isset($isWish))
                    <form id="add-to-wishlist" action="/customer/{{$product->id}}/wishlist/add">
                        <button class="myButton wishlist">
                        <span class="glyphicon glyphicon-heart">

                        </span>Add to wishlist
                        </button>
                    </form>
                @else
                    <form id="remove-from-wishlist" action="/customer/{{$product->id}}/wishlist/add">
                        <button class="btn btn-danger wishlist">
                        <span class="glyphicon glyphicon-heart">

                        </span>Add to wishlist
                        </button>
                    </form>
                @endif

                @role("customer")



                @if(\Auth::user()->cart->cartDetails()->quantity($product->id)->get()->isEmpty())
                    <button class="myButton add" data-toggle="modal" data-target="#addModal">Add To Cart</button>

                    <div class="modal fade" id="addModal" role="dialog">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Add To Cart</h4>
                                </div>
                                {!! Form::open(["action" => ["CustomerController@addToCart", $product]]) !!}
                                <div class="modal-body">
                                    <div class="form-group">
                                        {!! Form::label("Quantity") !!}
                                        {!! Form::number("quantity", null, ["class" => "form-control" , "min" => 1 , "max" => $product->quantity]) !!}
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    {!! Form::submit("Add to cart",["class" => "btn btn-default modalb"]) !!}
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
                                {!! Form::open(["action" => ["CustomerController@editCart", \Auth::user()->cart->cartDetails()->quantity($product->id)->first()]]) !!}
                                <div class="modal-body">
                                    <div class="form-group">
                                        {!! Form::label("Quantity") !!}
                                        {!! Form::number("quantity", \Auth::user()->cart->cartDetails()->quantity($product->id)->first()->quantity, ["class" => "form-control",  "min" => 1 , "max" => $product->quantity]) !!}
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
                                {!! Form::open(["action" => ["CustomerController@addToGuestCart", $product]]) !!}
                                <div class="modal-body">
                                    <div class="form-group">
                                        {!! Form::label("Quantity") !!}
                                        {!! Form::number("quantity", null, ["class" => "form-control" , "min" => 1 , "max" => $product->quantity]) !!}
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    {!! Form::submit("Add to cart",["class" => "btn btn-default modalb"]) !!}
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
            $('#ratingForm').on('submit', function (e) {
                e.preventDefault();
                var rating = $('.star:checked').val();
                $.ajax({
                    type: "POST",
                    url: '/customer/{{$product->id}}/rating/add',
                    data: {"star": rating},
                    datatype: 'JSON',
                    success: function(response) {
                        $('.stars').remove();
                        $('#ajaxResponse').append('<div class="alert alert-success">' + response.msg + '</div>');
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
            $('#add-to-wishlist').on('submit', function (e) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: '/customer/{{$product->id}}/wishlist/add',
                    data: {"star": rating},
                    datatype: 'JSON',
                    success: function(response) {

                    }
        })

    </script>
{{--@include('laravelLikeComment::like', ['like_item_id' => $product->id])--}}
@include('laravelLikeComment::comment', ['comment_item_id' => $product->id])
@endsection