@extends("layouts.customer")
@section("title")
    Tracking orders
@endsection

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-responsive table-hover">
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Progress</th>
                    </tr>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{$order->product->name}}</td>
                            <td>{{$order->quantity}}</td>
                            <td>{{$order->price}}$</td>
                            <td>
                                @if($status[$order->status][1] != "customer")
                                    <p>{{$status[$order->status][0]}}</p>
                                @else
                                    {!! Form::open(["action" => ["CustomerController@changeCheckoutStatus", $order]]) !!}
                                        {!! Form::button($status[$order->status][0],
                                        [
                                            "type" => "submit",
                                            "class" => "btn btn-primary"
                                        ]
                                        ) !!}
                                    {!! Form::close() !!}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection