@extends('layouts.admin')
@section("title")
    Featured requests
@endsection

@section("content")
    <table class="table table-responsive table-hover">
        <tr>
            <th>No.</th>
            <th>Product</th>
            <th colspan="2" class="text-center">Action</th>
        </tr>
        @foreach($featuredRequests as $request)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{link_to_action("CustomerController@productDetails", $request->product->name,[$request->product->category, $request->product])}}</td>
                <td>
                    {!! Form::open(["action" => ["AdminController@acceptFeaturedRequest", $request]]) !!}
                        {!! Form::submit("Accept", ["class" => "btn btn-success"]) !!}
                    {!! Form::close() !!}
                </td>
                <td>
                    {!! Form::open(["action" => ["AdminController@rejectFeaturedRequest", $request]]) !!}
                    {!! Form::submit("Reject", ["class" => "btn btn-danger"]) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
    </table>
@endsection