@extends('layouts.customer')
@section('title')
    Products
@endsection
@section('content')
<p>Product name: {{$product->name}}</p>
<p>Product price:
    @if($product->discount + $product->offer > 0)
        <s>{{$product->price}}$</s>
    @else
        {{$product->price}}$
    @endif
@if($product->discount + $product->offer > 0)
    {{$product->price - $product->discount / 100.0 * $product->price -  $product->offer / 100.0 * $product->price}}$
@endif

<p>Product quantity: {{$product->quantity}}</p>
<p>Category: {{$category->name}}</p>

@role("customer")
    @if(\Auth::user()->cart->cartDetails()->quantity($product->id)->get()->isEmpty())
        {{--{!! Form::open(["action" => ["CustomerController@addToCart", $product]]) !!}--}}
        {{--<div class="form-group">--}}
            {{--{!! Form::label("Quantity") !!}--}}
            {{--{!! Form::number("quantity", null, ["class" => "form-control"]) !!}--}}
        {{--</div>--}}
        {{--{!! Form::submit("Add to cart") !!}--}}
        {{--{!! Form::close() !!}--}}
        <button class="myButton add btn-lg" data-toggle="modal" data-target="#addModal">Add To Cart</button>

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
                            {!! Form::number("quantity", null, ["class" => "form-control"]) !!}
                        </div>
                    </div>
                    <div class="modal-footer">
                        {!! Form::submit("Add to cart",["class" => "btn btn-default modalb"]) !!}
                        {{--<button type="button" class="btn btn-default modalb" data-dismiss="modal" href="CustomerController@addToCart">Done</button>--}}
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    @else
        {{--{!! Form::open(["action" => ["CustomerController@editCart", \Auth::user()->cart->cartDetails()->quantity($product->id)->first()]]) !!}--}}
        {{--<div class="form-group">--}}
            {{--{!! Form::label("Quantity") !!}--}}
            {{--{!! Form::number("quantity", \Auth::user()->cart->cartDetails()->quantity($product->id)->first()->quantity, ["class" => "form-control"]) !!}--}}
        {{--</div>--}}
        {{--{!! Form::submit("Edit cart") !!}--}}
        {{--{!! Form::close() !!}--}}
        <button class="myButton add btn-lg" data-toggle="modal" data-target="#editModal">Edit Cart</button>

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
                            {!! Form::number("quantity", \Auth::user()->cart->cartDetails()->quantity($product->id)->first()->quantity, ["class" => "form-control"]) !!}
                        </div>
                    </div>
                    <div class="modal-footer">
                        {!! Form::submit("Edit cart",["class" => "btn btn-default modalb"]) !!}
                        {{--<button type="button" class="btn btn-default modalb" data-dismiss="modal" href="CustomerController@addToCart">Done</button>--}}
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    @endif

@if(\Auth::user() && !isset($isWish))
    <p><a href="{{action("CustomerController@addToWishList", [$product])}}" class="btn btn-success btn-group-lg">Add to My Wishlist</a></p>
@endif
@endrole
@include('comments::comments-react', [
'content_type' => App\Product::class,
'content_id' => $product->id
])
@endsection