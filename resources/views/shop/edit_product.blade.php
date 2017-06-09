@extends("layouts.vendor")
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
    <div class="row" style="margin-top: 40px;">
        <div class="col-md-12">
            <h3 class="text-center">Product images</h3>
        </div>
    </div>
    @foreach($product->images as $image)
        <div class="row" style="margin-top: 30px;">
            <div class="col-md-3">
                {{$image->image_name}}
            </div>
            <div class="col-md-6">
                <img src="{{route("image", $image->stored_name)}}" />
            </div>
            <div class="col-md-3">
                {!! Form::open(["action" => ["VendorController@deleteProductImage", $image]]) !!}
                    {!! Form::submit("Delete image", ["class" => "btn btn-danger"]) !!}
                {!! Form::close() !!}
            </div>
        </div>
    @endforeach
</div>

@endsection