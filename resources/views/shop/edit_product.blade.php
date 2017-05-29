@extends("layouts.admin")
@section("title")
    Edit Product
@endsection
@section("content")
<div class="container">
    <div class="row">
        {!! Form::model($product, ["action" => ["VendorController@editProduct", $category->id, $product->id], "enctype" => "multipart/form-data"]) !!}
            @include("shop._form", ["submitButton" => "Edit product"])
        {!! Form::close() !!}
    </div>
</div>

@endsection