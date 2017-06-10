@extends("layouts.admin")
@section("title")
    New shipping zone
@endsection
@section("content")
{!! Form::open(["action" => "AdminController@newShippingZone"]) !!}
    @include("admin._shipping_zone_form", ["submitButton" => "Add new"])
{!! Form::close() !!}
@endsection