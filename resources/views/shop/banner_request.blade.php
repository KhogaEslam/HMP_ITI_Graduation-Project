@extends("layouts.vendor")
@section("title")
    Request Adding Banner
@endsection
@section("content")

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                {!! Form::open(["action" => "VendorController@addBannerRequest", "enctype" => "multipart/form-data"]) !!}

                <div class="form-group">
                    <label>Banner Type</label>
                    {!! Form::select('type', array(0 => 'Banner For Product', 1 => 'Banner For My Shop'), 0, ["class" => "form-control"]) !!}
                </div>

                <div class="form-group product">
                    {!! Form::label("Products") !!}
                    {!! Form::select('product', $products, 0, ["class" => "form-control"]) !!}
                </div>

                <div class="form-group">
                    <label>Banner Image</label>
                    {!! Form::file('image', null, ["class" => "form-control"]) !!}
                </div>

                <div class="form-group">
                    <label>Start date</label>
                    {!! Form::date("start_date", null, ["class" => "form-control"]) !!}
                </div>

                <div class="form-group">
                    <label>End date</label>
                    {!! Form::date("end_date", null, ["class" => "form-control"]) !!}
                </div>
                {!! Form::submit("Request Adding Banner", ["class" => "btn btn-primary btn-block"]) !!}
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

    <script>
        $(document).ready(function() {
            $("select[name=type]").change(function(e) {
                var option = $("select[name=type] :selected").val();
                if(option == 0) {
                    $(".product").slideDown();
                }
                else {
                    $(".product").slideUp();
                }
            });
        });
    </script>

@endsection