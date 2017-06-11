<div class="form-group">
    {!! Form::label("Shipping zone name") !!}
    {!! Form::text("name", null, ["class" => "form-control"]) !!}
</div>
{!! Form::submit($submitButton, ["class" => "btn btn-default"]) !!}