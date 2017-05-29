@extends("layouts.admin")
@section("title")
    Product
@endsection
@section("content")

<p>Product name: {{$product->name}}</p>
<p>Product price: {{$product->price}}</p>
<p>Product quantity: {{$product->quantity}}</p>
<p>Category: {{$category->name}}</p>
<p></p>

@if (!isset($discount))
<p><a href="{{action("VendorController@showDiscountProductForm", [$product->id])}}" class="btn btn-primary btn-block">Add Discount</a></p>
@else
    <h5>Discount Details :</h5>
    <p>Discount: {{$discount->percentage}} %</p>
    <p>Start date : {{$discount->start_date}} </p>
    <p>End date : {{$discount->end_date}} </p>
    <p><a href="{{action("VendorController@deleteDiscount", [$discount])}}" class="btn btn-danger btn-block">Delete Discount</a></p>
@endif

@if (!isset($featuredItem))
    <p><a href="{{action("VendorController@makeFeaturedItemRequest", [$product])}}" class="btn btn-success btn-block">Make Featured Items</a></p>
@endif

@endsection