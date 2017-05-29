@extends('layouts.customer')
@section('title')
    {{\Auth::user()->name}} WishList
@endsection
@section('content')
    <div class="container">
        @foreach($wishList as $item)
            <div class="row" style="margin-bottom: 20px;">
                <div class="col-md-3" style="padding-top: 80px;">
                    {{$item->product->name}}
                </div>
                <div class="col-md-4">
                    <img src="{{route("image", $item->product->images->first()->stored_name)}}" class="img-fluid img-responsive" height="20" />
                </div>

                <div class="col-md-3" style="padding-top: 80px;">
                    <p><a href="{{action("CustomerController@deleteFromWishList", [$item])}}" class="btn btn-danger btn-group-lg">Delete from my list</a></p>
                </div>
            </div>
        @endforeach
    </div>

@endsection