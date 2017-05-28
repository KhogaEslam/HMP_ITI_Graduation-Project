@extends("layouts.admin")
@section("title")
    Product
@endsection
@section("content")

<p>Product name: {{$product->name}}</p>
<p>Product price: {{$product->price}}</p>
<p>Product quantity: {{$product->quantity}}</p>
<p>Category: {{$category->name}}</p>

@if ($discount->isEmpty())
<p><a href="{{action("VendorController@showDiscountProductForm", [$product->id])}}" class="btn btn-primary btn-block">Add Discount</a></p>
@else
<p><a href="{{action("VendorController@showEditDiscountProductForm", [$product->id])}}" class="btn btn-primary btn-block">Edit Discount</a></p>
@endif
@endsection