@extends('layouts.customer')
@section('title')
    {{\Auth::user()->name}} WishList
@endsection
@section('content')
    <div class="row allCart">
        <div class="container">
            <div class="col-md-9 col-sm-12">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Product</th>
                        <th>Action</th>
                        <th> </th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($wishList as $item)
                        <tr>
                            <td class="">
                                <div class="media">
                                    <a class="thumbnail pull-left" href="#">
                                        @if($item->product->images->first() !== null)
                                            <img class="media-object" src="{{route("image", $item->product->images->first()->stored_name)}}" style="width: 72px; ">
                                    @endif
                                    </a>

                                    <div class="media-body">
                                        <h4 class="media-heading"><a href="#"> {{$item->product->name}}</a></h4>
                                    </div>
                                </div>
                            </td>
                            <td class="-1 text-center" style="text-align: center">
                                <p><a href="{{action("CustomerController@deleteFromWishList", [$item])}}" class="btn remove">Remove</a></p>
                            </td>
                        </tr>
                    @empty
                        <h1 class="text-danger text-center">Your List is Empty</h1>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection