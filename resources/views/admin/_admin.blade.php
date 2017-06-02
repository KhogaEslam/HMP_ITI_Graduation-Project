<div class="form-group">
    <label>Name</label>
    {!! Form::text("name", null, ["class" => "form-control"]) !!}
</div>
@if(! $edit)
    <div class="form-group">
        <label>Email</label>
        {!! Form::email("email", null, ["class" => "form-control"]) !!}
    </div>
@endif

<div class="form-group">
    <label>Password</label>
    {!! Form::password("password", ["class" => "form-control"]) !!}
</div>

<div class="form-group">
    <label>Password confirmation</label>
    {!! Form::password("password_confirmation", ["class" => "form-control"]) !!}
</div>

<div class="form-group">
    <label>Birth date</label>
    {!! Form::date("date_of_birth", null, ["class" => "form-control"]) !!}
</div>

<div class="form-group">
    {!! Form::submit($submitButton, ["class" => "form-control btn btn-primary"]) !!}
</div>

@foreach($errors->all() as $error)
    <p>{{$error}}</p>
@endforeach
