@extends("layouts.admin")
@section("content")

{!! Form::model($employee->self, ["action" => ["VendorController@editEmployee", $employee]]) !!}
    @include("shop._employee", ["submitButton" => "Edit employee", "edit" => true])
{!! Form::close() !!}

@endsection