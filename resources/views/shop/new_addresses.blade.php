@extends("layouts.vendor")
@section("title")
    Shop Addresses
@endsection

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                {!! Form::open(["action" => "VendorController@newAddress", "name" => "address"]) !!}
                    <div class="form-group">
                        {!! Form::label("Address #1") !!}
                        {!! Form::text("new_addresses[]", null, ["class" => "form-control"]) !!}
                    </div>
                    @if(! $errors->isEmpty())
                        <div class="alert alert-danger">
                            <h5>One or more fields are empty</h5>
                        </div>
                    @endif
                    <button class="btn btn-primary" type="button" id="add_new_address">Add new</button>
                    {!! Form::submit("Save", ["class" => "pull-right btn btn-success"]) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            var counter = 1
            $("#add_new_address").click(function(e) {
                $('<div class="form-group"><label>Address #' + ++counter + '</label>{!! Form::text("new_addresses[]", null, ["class" => "form-control"]) !!}</div>').insertBefore("#add_new_address")
            });
        });
    </script>
@endsection