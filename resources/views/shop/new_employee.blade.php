@extends("layouts.admin")
@section("content")

{!! Form::open(["action" => ["VendorController@newEmployee"]]) !!}
    @include("shop._employee", ["submitButton" => "Add new employee", "edit" => false])
{!! Form::close() !!}

@endsection