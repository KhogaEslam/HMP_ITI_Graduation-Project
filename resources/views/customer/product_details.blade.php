@extends('layouts.customer')
@section('title')
    Products
@endsection
@section('content')
<p>Product name: {{$product->name}}</p>
<p>Product price: {{$product->price}}</p>
<p>Product quantity: {{$product->quantity}}</p>
<p>Category: {{$category->name}}</p>
@endsection