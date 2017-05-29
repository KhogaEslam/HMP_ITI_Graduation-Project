@extends("layouts.customer")
@section("title")
    {{\Auth::user()->name}} Shopping cart
@endsection

@section("content")
    <div class="container">
        @foreach($cartDetails as $cartDetail)
            <div class="row" style="margin-bottom: 20px;">
                <div class="col-md-3" style="padding-top: 80px;">
                    {{$cartDetail->product->name}}
                </div>
                <div class="col-md-4">
                    <img src="{{route("image", $cartDetail->product->images->first()->stored_name)}}" class="img-fluid img-responsive" height="20" />
                </div>
                <div class="col-md-2 text-lg-center">
                    @if($cartDetail->product->discount + $cartDetail->product->offer > 0)
                        <s>{{$cartDetail->product->price * $cartDetail->quantity}}$</s>
                    @else
                        {{$cartDetail->product->price * $cartDetail->quantity}}$
                    @endif
                    @if($cartDetail->product->discount + $cartDetail->product->offer > 0)
                        {{($cartDetail->product->price - $cartDetail->product->offer / 100.0 * $cartDetail->product->price - $cartDetail->product->discount / 100.0 * $cartDetail->product->price) * $cartDetail->quantity}}$
                    @endif
                </div>
                <div class="col-md-1" style="padding-top: 80px;">
                    {!! Form::model($cartDetail, ["action", "CustomerController@editCart", $cartDetail]) !!}
                        <div class="form-group">
                            {!! Form::label("Quantity") !!}
                            {!! Form::text("quantity", null, ["class" => "form-control"]) !!}
                        </div>
                        {!! Form::submit("Update cart") !!}
                    {!! Form::close() !!}
                </div>
                <div class="col-md-2" style="padding-top: 100px;">
                    {!! Form::open(["action" => ["CustomerController@deleteProductFromCart", $cartDetail]]) !!}
                        {!! Form::button
                        (
                            "<i class='fa fa-times-circle-o pull-left text-danger'></i> Delete this product",
                             [
                                "type" => "submit",
                                "class" => "btn btn-warning"
                             ]
                        )
                        !!}
                    {!! Form::close() !!}
                </div>
            </div>
        @endforeach
        <div class="row">
            <div class="col-md-8">

            </div>
            <div class="col-md-4 text-center">
                <h3>Total</h3>
                <p>{{$total}}$</p>
            </div>
        </div>
    </div>
@endsection