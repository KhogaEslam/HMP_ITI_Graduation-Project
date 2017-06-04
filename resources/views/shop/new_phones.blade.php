@extends("layouts.vendor")
@section("title")
    Shop phones
@endsection

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                {!! Form::open(["action" => "VendorController@newPhones", "name" => "phone"]) !!}
                    <div class="form-group">
                        {!! Form::label("phone #1") !!}
                        {!! Form::text("new_phones[]", null, ["class" => "form-control"]) !!}
                    </div>
                @if(! $errors->isEmpty())
                    <div class="alert alert-danger">
                        <h5>Please check your phone numbers</h5>
                    </div>
                @endif
                <button class="btn btn-primary" type="button" id="add_new_phone">Add new</button>
                {!! Form::submit("Save", ["class" => "pull-right btn btn-success"]) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            var counter = 1
            $("#add_new_phone").click(function(e) {
                $('<div class="form-group"><label>phone #' + ++counter + '</label>{!! Form::text("new_phones[]", null, ["class" => "form-control"]) !!}</div>').insertBefore("#add_new_phone")
            });
        });
    </script>
@endsection