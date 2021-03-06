<div class="form-group">
    {!! Form::label("name", "Product name") !!}
    {!! Form::text("name", null, ['class' => "form-control"]) !!}
</div>
<div class="form-group">
    {!! Form::label("description", "Description") !!}
    {!! Form::textarea("description", null, ["class" => "form-control", "cols" => 40, "rows" => 8, "style" => "resize: none;"]) !!}
</div>
<div class="form-group">
    {!! Form::label("quantity") !!}
    {!! Form::number("quantity", null, ["class" => "form-control", "min" => 1]) !!}
</div>
<div class="form-group">
    {!! Form::label("price") !!}
    {!! Form::number("price", null, ["class" => "form-control", "step" => "any", "min" => 0]) !!}
</div>
<div class="form-group">
    {!! Form::label("images") !!}
    {!! Form::file('images[]', array('multiple'=>true)) !!}
</div>

{!! Form::submit($submitButton, ["class" => "btn btn-block btn-info"]) !!}

@foreach($errors->all() as $error)
    <p class="text-danger">* {{$error}}</p>
@endforeach