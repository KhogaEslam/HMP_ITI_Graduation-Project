@extends("layouts.vendor")
@section("title")
    Order Details
@endsection

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-primary">Order details</h1>
            </div>
        </div>
        <div class="row">
            <table class="table">
                <tr>
                    <th class="text-primary">Product name</th>
                    <td>{{$order->product->name}}</td>
                </tr>
                <tr>
                    <th class="text-primary">Shop</th>
                    <td>{{$order->shop->email}}</td>
                </tr>
                <tr>
                    <th class="text-primary">Customer</th>
                    <td>{{$order->user->email}}</td>
                </tr>
                <tr>
                    <th class="text-primary">Price</th>
                    <td>{{$order->price}}$</td>
                </tr>
                <tr>
                    <th class="text-primary">Quantity</th>
                    <td>{{$order->quantity}}</td>
                </tr>
                <tr>
                    <th class="text-primary">Order date</th>
                    <td>{{$order->created_at}}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection