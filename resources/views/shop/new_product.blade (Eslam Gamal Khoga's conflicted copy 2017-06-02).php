@extends("layouts.vendor")
@section("title")
    New Product
@endsection
@section("content")

<div class="container">
    <div class="row">
        {!! Form::open(["action" => ["VendorController@newProduct", $category], "enctype" => "multipart/form-data"]) !!}
            @include("shop._form", ["submitButton" => "New product"])
        {!! Form::close() !!}
    </div>
</div>

@endsection