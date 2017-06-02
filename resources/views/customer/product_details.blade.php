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
    <div class="stars">
        <form action="">
            <input class="star star-5" id="star-5" type="radio" name="star"/>
            <label class="star star-5" for="star-5"></label>
            <input class="star star-4" id="star-4" type="radio" name="star"/>
            <label class="star star-4" for="star-4"></label>
            <input class="star star-3" id="star-3" type="radio" name="star"/>
            <label class="star star-3" for="star-3"></label>
            <input class="star star-2" id="star-2" type="radio" name="star"/>
            <label class="star star-2" for="star-2"></label>
            <input class="star star-1" id="star-1" type="radio" name="star"/>
            <label class="star star-1" for="star-1"></label>
        </form>
    </div>
    @if(\Auth::user()->cart->cartDetails()->quantity($product->id)->get()->isEmpty())
        {!! Form::open(["action" => ["CustomerController@addToCart", $product]]) !!}
        <div class="form-group">
            {!! Form::label("Quantity") !!}
            {!! Form::number("quantity", null, ["class" => "form-control"]) !!}
        </div>
        {!! Form::submit("Add to cart") !!}
        {!! Form::close() !!}
    @else
        {!! Form::open(["action" => ["CustomerController@editCart", \Auth::user()->cart->cartDetails()->quantity($product->id)->first()]]) !!}
        <div class="form-group">
            {!! Form::label("Quantity") !!}
            {!! Form::number("quantity", \Auth::user()->cart->cartDetails()->quantity($product->id)->first()->quantity, ["class" => "form-control"]) !!}
        </div>
        {!! Form::submit("Edit cart") !!}
        {!! Form::close() !!}
    @endif

@if(\Auth::user() && !isset($isWish))
    <p><a href="{{action("CustomerController@addToWishList", [$product])}}" class="btn btn-success btn-group-lg">Add to My Wishlist</a></p>
@endif
@endrole

@endsection