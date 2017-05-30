@extends('layouts.admin')
@section("title")
    Banner requests
@endsection

@section("content")
    <table class="table table-responsive table-hover">
        <tr>
            <th>No.</th>
            <th>Request Type</th>
            <th>Image</th>
            <th colspan="2" class="text-center">Action</th>
        </tr>
        @foreach($bannerRequests as $bannerRequest)
            <tr>
                <td>{{$loop->iteration}}</td>
                @if($bannerRequest->type == 0)
                    <td>Product</td>
                @else
                    <td>Shop</td>
                @endif
                <td>
                    <img src="{{route("banner", [$bannerRequest->image])}}" width="300px">
                </td>
                <td>
                    {!! Form::open(["action" => ["AdminController@acceptBannerRequest", $bannerRequest]]) !!}
                    {!! Form::submit("Accept", ["class" => "btn btn-success"]) !!}
                    {!! Form::close() !!}
                </td>
                <td>
                    {!! Form::open(["action" => ["AdminController@rejectBannerRequest", $bannerRequest]]) !!}
                    {!! Form::submit("Reject", ["class" => "btn btn-danger"]) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
    </table>
@endsection