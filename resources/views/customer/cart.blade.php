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
            {{-- check out --}}
            <div class="col-md-4 text-center">
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                    <input type="hidden" name="cmd" value="_xclick">
                    <input type="hidden" name="business" value="mgmhardwaremarketplace@gmail.com">

                    <input type="hidden" name="item_name_1" value="Donation">
                    <input type="hidden" name="item_number_1" value="1">
                    <input type="hidden" name="amount_1" value="9.00">
                    <input type="hidden" name="no_shipping_1" value="0">

                    <input type="hidden" name="item_name_2" value="Donation">
                    <input type="hidden" name="item_number_2" value="1">
                    <input type="hidden" name="amount_1" value="9.00">
                    <input type="hidden" name="no_shipping_1" value="0">

                    <input type="hidden" name="no_note" value="1">
                    <input type="hidden" name="currency_code" value="USD">
                    <input type="hidden" name="lc" value="AU">
                    <input type="hidden" name="bn" value="PP-BuyNowBF">
                    <input type="image" src="https://www.paypal.com/en_AU/i/btn/btn_buynow_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online.">
                    <img alt="" border="0" src="https://www.paypal.com/en_AU/i/scr/pixel.gif" width="1" height="1">
                </form>
            </div>
        </div>
    </div>
@endsection