@extends("layouts.customer")
@section("title")
    {{\Auth::check() ? \Auth::user()->name : "Guest"}} Shopping cart
@endsection

@section("content")

    <div class="row allCart">
        <div class="container">
            <div class="col-md-9 col-sm-12">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Total</th>
                        <th> </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($cartDetails as $cartDetail)
                    <tr>
                        <td class="">
                            <div class="media">
                                <a class="thumbnail pull-left" href="#">
                                    @if($cartDetail->product->images->first() !== null)
                                        <img class="media-object" src="{{route("image", $cartDetail->product->images->first()->stored_name)}}" style="width: 72px; "> </a>

                                @endif
                                <div class="media-body">
                                    <h4 class="media-heading"><a href="#"> {{$cartDetail->product->name}}</a></h4>
                                    <h5 class="media-heading"> In <a href="#">{{$cartDetail->product->category->name}}</a></h5> <span>Status: </span><span class="text-success"><strong>In Stock</strong></span> </div>
                            </div>
                        </td>
                        <td class="" style="text-align: center">
                            {{--<input type="number" class="form-control" value="{{$cartDetail->quantity}}">--}}
                            @role("customer")
                            {!! Form::model($cartDetail, ["action" => ["CustomerController@editCart", $cartDetail], 'class' => 'edit-cart']) !!}
                            @endrole
                            @if(! \Auth::check() || ! \Auth::user()->hasRole("customer"))
                            {!! Form::model($cartDetail, ["action" => ["CustomerController@editGuestCart", $cartDetail->product->id], 'class' => 'edit-cart', "min" => 1 , "max" => $cartDetail->product->quantity]) !!}
                            @endif
                                {!! Form::number("quantity", null, ["class" => "form-control cart-quantity", "min" => 1 , "max" => $cartDetail->product->quantity]) !!}
                                {!! Form::submit("Submit", ["class" => "btn myButton submit-q"] )!!}
                            {!! Form::close() !!}
                        </td>
                        <td class=" text-center"><strong>{{$cartDetail->product->price}}$</strong></td>

                        @if($cartDetail->product->discount > 0)
                            <td class="-1 text-center"><strong><s>{{$cartDetail->product->price * $cartDetail->quantity}}$</s></strong></td>
                            <td class="-1 text-center"><strong>{{($cartDetail->product->price - $cartDetail->product->discount / 100.0 * $cartDetail->product->price) * $cartDetail->quantity}}$</strong>
                                @role("customer")
                                {!! Form::open(["action" => ["CustomerController@deleteProductFromCart", $cartDetail]]) !!}
                                @endrole
                                @if(! \Auth::check() || ! \Auth::user()->hasRole("customer"))
                                    {!! Form::open(["action" => ["CustomerController@deleteFromGuestCart", $cartDetail->product->id]]) !!}
                                @endif
                                {!! Form::button("Remove",["type" => "submit","class" => "btn remove"])!!}
                                {!! Form::close() !!}
                            </td>
                        @else
                            <td>&nbsp;&nbsp;---</td>
                            <td class="-1 text-center"><strong>{{$cartDetail->product->price * $cartDetail->quantity}}$</strong>
                                @role("customer")
                                {!! Form::open(["action" => ["CustomerController@deleteProductFromCart", $cartDetail]]) !!}
                                @endrole
                                @if(! \Auth::check() || ! \Auth::user()->hasRole("customer"))
                                    {!! Form::open(["action" => ["CustomerController@deleteFromGuestCart", $cartDetail->product->id]]) !!}
                                @endif
                                {!! Form::button("Remove",["type" => "submit","class" => "btn remove"])!!}
                                {!! Form::close() !!}
                            </td>
                        @endif
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                <form action="{{url("/")}}">
                    <button type="submit" class="btn con pull-right"> <span class="glyphicon glyphicon-shopping-cart"></span> Continue Shopping </button>
                </form>
            </div>
            <div class="col-md-3 col-sm-12 cart">
                <ul>
                    <h4>Your Cart</h4>
                    <hr>
                    <li><span>SUBTOTAL</span> <span class="totalp">{{$total}}$</span></li>
                    <hr>
                    <li><span>Offer</span> <span class="totalp">{{$offer}}%</span></li>
                    <hr>
                    <li><span>TOTAL</span> <span class="totalp">{{$final_total}}$</span></li>
                </ul>
                @if(! $cartDetails->isEmpty())
                {!! Form::open(["action" => ["CustomerController@cashCheckout"]]) !!}
                {{--<button class="myButton center-block">CHECK OUT</button>--}}
                {!! Form::button("Checkout", [
                    "type" => "submit",
                    "class" => "myButton center-block"
                ]) !!}
                {!! Form::close() !!}
                @role("customer")
                <h5>or</h5>
                {{-- check out --}}
                <div class="col-md-4 text-center">
                    <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
                        <input TYPE="hidden" name="charset" value="utf-8">
                        <input type="hidden" name="cmd" value="_cart">
                        <input type="hidden" name="upload" value="1">
                        <input type="hidden" name="business" value="gbusiness@gadget.ly">



                        <?php $counter=1; ?>
                        @foreach($cartDetails as $cartDetail)
                            <input type="hidden" name="item_name_{{$loop->iteration}}" value="{{$cartDetail->product->name}}">
                            <input type="hidden" name="quantity_{{$loop->iteration}}" value="{{$cartDetail->quantity}}">
                            <input type="hidden" name="amount_{{$loop->iteration}}" value="{{$cartDetail->product->price}}">

                            @if($offer > 0)
                                <input type="hidden" name="discount_rate_cart" value="{{$offer}}">
                            @elseif($cartDetail->product->discount > 0)
                                <input type="hidden" name="discount_rate_{{$loop->iteration}}" value="{{$cartDetail->product->discount}}">
                            @endif

                        @endforeach

                        <input type="hidden" name="custom" value="{{$cartDetails->first()->cart->id}}"/>
                        <input type="hidden" name="shopping_url" value="{{ url('/') }}">
                        <input TYPE="hidden" name="return" value="{{ url('/') }}">
                        <input TYPE="hidden" name="cancel_return" value="{{ url('customer/cart') }}">
                        <input type="hidden" name="notify_url" value="{{ url('api/payment/confirm') }}">
                        <button type="submit" class="paypalbutton center-block"> <span>Check out with</span> <span>

                    <img class="pay" src="{{asset('images/PayPal.svg.png')}}">
                    </span></button>
                    </form>
                </div>
                    @endrole

                @endif

            </div>
        </div>
    </div>
    <div class="x-cart-notification">
        <div class="x-cart-notification-icon loading">
            <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
        </div>
        <div class="x-cart-notification-icon added">
            <i class="fa fa-check" aria-hidden="true"></i>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $(document).on('submit', ".edit-cart", function(e) {
                e.preventDefault();
                var quantity  = $('[name= "quantity"]').val()
                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: {"quantity" : quantity},
                    datatype: 'JSON',
                    success: function(response) {
                        if (response.status == "success") {
                            $('.x-cart-notification').addClass('bring-forward appear loading');
                            $('.modal-close').click();
                            setTimeout(function () {
                                $('.x-cart-notification').addClass('added');
                            }, 1400)
                            setTimeout(function () {
                                $('.x-cart-notification').removeClass('bring-forward appear loading added');
                                $('.incart-quantity').html(response.inCart);
                                location.reload();
                            }, 2800)
                        }
                        else {

                            if (response.msg) {
                                alert(response.msg)
                            }
                            else {
                                alert("Error")
                            }
                        }

                    },
                    error: function(response){
                        if (response.msg) {
                            alert(response.msg)
                        }
                        else {
                            alert("Error")
                        }
                    }
                })
            });
        })

    </script>


    {{--<div class="col-md-1" style="padding-top: 80px;">--}}
        {{--{!! Form::model($cartDetail, ["action", "CustomerController@editCart", $cartDetail]) !!}--}}
        {{--<div class="form-group">--}}
            {{--{!! Form::label("Quantity") !!}--}}
            {{--{!! Form::text("quantity", null, ["class" => "form-control"]) !!}--}}
        {{--</div>--}}
        {{--{!! Form::submit("Update cart") !!}--}}
        {{--{!! Form::close() !!}--}}
    {{--</div>--}}

@endsection
