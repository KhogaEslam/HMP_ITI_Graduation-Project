@extends("layouts.admin")
@section("title")
    Edit shipping zone
@endsection
@section("content")
{!! Form::model($zone, ["action" => ["AdminController@editShippingZone", $zone]]) !!}
    @include("admin._shipping_zone_form", ["submitButton" => "Save changes"]);
{!! Form::close() !!}
@endsection