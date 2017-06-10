@extends("layouts.admin")
@section("title")
    Orders History
@endsection
@section("content")
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-hover">
                    <tr>
                        <th>Product name</th>
                        <th>Quantity</th>
                        <th>Order date</th>
                    </tr>
                    @foreach($orders as $order)
                        <tr>
                            <td>
                                <a href="{{action("AdminController@orderDetails", [$order])}}" class="text-primary" style="text-decoration: none;">{{$order->product->name}}</a>
                            </td>
                            <td>{{$order->quantity}}</td>
                            <td>{{$order->created_at}}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection