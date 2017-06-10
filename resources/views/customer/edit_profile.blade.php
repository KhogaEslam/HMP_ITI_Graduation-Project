@extends("layouts.customer")
@section("title")
    Edit profile
@endsection

@section("content")
    <div class="container">
        <div class="row">
            <div class="center-block sign-up">
                {!! Form::model(\Auth::user(), ["action" => ["CustomerController@editCustomerProfile"]]) !!}
                    <div class="form-group">
                        {!! Form::label("Name") !!}
                        {!! Form::text("name", null, ["class" => "form-control"]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label("Password") !!}
                        {!! Form::password("password", ["class" => "form-control"]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label("Password confirmation") !!}
                        {!! Form::password("password_confirmation", ["class" => "form-control"]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label("Birth date") !!}
                        {!! Form::date("date_of_birth", \Auth::user()->userDetails->first()->date_of_birth, ["class" => "form-control"]) !!}
                    </div>
                    {!! Form::submit("Save changes", ["class" => "  myButton center-block"]) !!}
                {!! Form::close() !!}
                @foreach($errors->all() as $error)
                    <p class="text-danger">* {{$error}}</p>
                @endforeach
            </div>
        </div>
    </div>
@endsection