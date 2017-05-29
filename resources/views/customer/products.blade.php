@extends('layouts.customer')
@section('title')
    Products
@endsection
@section('content')
    <div class="container">
        <div class="row">
            @forelse($products as $product)
                <div class="col-md-4">
                    <div class="thumbnail">
                        @if(! $product->images()->get()->isEmpty())
                            <a href="{{action("CustomerController@productDetails", [$category->id, $product->id])}}">
                                <img src="{{route("image", [$product->images()->get()->first()->stored_name])}}" class="img-responsive img-fluid img-rounded" width="235" height="235" alt="No image provided">
                            </a>
                        @else
                            <img alt="No image provided">
                        @endif
                        <div class="caption">
                            <a class="text-warning" href="{{action("CustomerController@productDetails", [$category->id, $product->id])}}">
                                <h3>{{$product->name}}</h3>
                            </a>
                        </div>
                    </div>

                </div>
            @empty
                <h1 class="text-danger text-center">No products yet</h1>
            @endforelse

        </div>
    </div>

@endsection