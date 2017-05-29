@extends("layouts.admin");
@section("content")

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                {!! Form::open(["action" => "AdminController@addOffer"]) !!}
                    <div class="form-group">
                        <label>Percentage</label>
                        {!! Form::number("percentage", null, ["class" => "form-control", "min" => 1, "max" => 100]) !!}
                    </div>
                    <div class="form-group">
                        <label>Start date</label>
                        {!! Form::date("start_date", null, ["class" => "form-control"]) !!}
                    </div>

                    <div class="form-group">
                        <label>End date</label>
                        {!! Form::date("end_date", null, ["class" => "form-control"]) !!}
                    </div>
                    {!! Form::submit("Add offer", ["class" => "btn btn-primary btn-block"]) !!}
                {!! Form::close() !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @foreach($errors->all() as $error)
                    <div class="alert alert-danger">
                        {{$error}}
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection