{!! Form::model($product, ["action" => ["VendorController@editProduct", $category->id, $product->id], "enctype" => "multipart/form-data"]) !!}
    @include("shop._form", ["submitButton" => "Edit product"])
{!! Form::close() !!}