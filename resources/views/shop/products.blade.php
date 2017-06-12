@extends("layouts.vendor")
@section("title")
    Products
@endsection
@section("content")

<div class="container">
    <div class="row">
        @forelse($products as $product)
            <div class="col-md-4">
                <div class="thumbnail">
                    @if(! $product->images()->get()->isEmpty())
                        <a href="{{action("VendorController@productDetails", [$category->id, $product->id])}}">
                            <img src="{{route("image", [$product->images()->get()->first()->stored_name])}}" class="img-responsive img-fluid img-rounded" style="width:auto;height:200px;display: block;text-align:center;margin-right:auto;margin-left:auto" alt="No image provided">
                        </a>
                    @else
                        <img alt="No image provided">
                    @endif
                    <div class="caption">
                        <a href="{{action("VendorController@productDetails", [$category->id, $product->id])}}">
                            <h3 style="padding-left: 10px;font-size: 16px;height: 40px;overflow: hidden;line-height: 1.4;">{{$product->name}}</h3>
                        </a>
                        <p><a href="{{action("VendorController@showEditProductForm", [$category->id, $product->id])}}" class="btn btn-primary btn-block">Edit product</a></p>
                        <p>{!! Form::open(["action" => ["VendorController@deleteProduct", $category, $product]]) !!}
                        {{ Form::button(
                            "Delete product",
                            array(
                                'class'=>'btn btn-block btn-danger',
                                'type'=>'submit'))
                        }}</p>
                        {!! Form::close() !!}
                        <p>
                        @if($product->published)
                            {!! Form::open(["action" => ["VendorController@unPublishProduct", $category, $product]]) !!}
                            {{ Form::button(
                                "Unpublish product",
                                array(
                                    'class'=>'btn btn-danger btn-block',
                                    'type'=>'submit'))
                            }}
                            {!! Form::close() !!}
                        @else
                            {!! Form::open(["action" => ["VendorController@publishProduct", $category, $product]]) !!}
                            {{ Form::button(
                                "Publish product",
                                array(
                                    'class'=>'btn btn-success btn-block',
                                    'type'=>'submit'))
                            }}
                            {!! Form::close() !!}
                        @endif
                        </p>
                    </div>
                </div>

            </div>
        @empty
            <h1 class="text-danger text-center">No products yet</h1>
        @endforelse
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                </div>
                <div class="col-md-6">
                    {!! $products->links("vendor.pagination.bootstrap-4") !!}
                </div>
            </div>
        </div>

    </div><a href="{{action("VendorController@showNewProductForm", [$category])}}" class="btn btn-warning pull-right"><i class="fa fa-plus-circle"></i> Add new product</a>
</div>

@endsection