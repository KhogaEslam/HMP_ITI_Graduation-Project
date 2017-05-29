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
@endrole

@endsection