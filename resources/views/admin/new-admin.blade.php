@extends("layouts.admin ")
@section("title")
    Admin Panel | New Admin user
@endsection
@section("content")
    <h1 class="bordered-heading">
        New Admin User
    </h1>
    {!! Form::open(["action" => ["AdminController@createAdminUser"]]) !!}
    @include("admin._admin", ["submitButton" => "Add new Admin", "edit" => false])
    {!! Form::close() !!}

@endsection