<div class="form-group">
    {!! Form::label("name", "Product name") !!}
    {!! Form::text("name", null, ['class' => "form-control"]) !!}
</div>
<div class="form-group">
    {!! Form::label("description", "Description") !!}
    {!! Form::textarea("description", null, ["class" => "form-control", "cols" => 40, "rows" => 3, "style" => "resize: none;"]) !!}
</div>
<div class="form-group">
    {!! Form::label("quantity") !!}
    {!! Form::number("quantity") !!}
</div>
<div class="form-group">
    {!! Form::label("price") !!}
    {!! Form::number("price", null, ["class" => "form-control", "step" => "any"]) !!}
</div>
<div class="form-group">
    {!! Form::label("images") !!}
    {!! Form::file('images[]', array('multiple'=>true)) !!}
</div>
<div class="form-control">
    {!! Form::submit($submitButton) !!}
</div>