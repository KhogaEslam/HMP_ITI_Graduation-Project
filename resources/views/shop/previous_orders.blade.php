@extends("layouts.vendor")
@section("title")
    Completed orders
@endsection

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h3>Name</h3>
            </div>
            <div class="col-md-3">
                <h3>Category</h3>
            </div>
            <div class="col-md-3">
                <h3>Quantity</h3>
            </div>
            <div class="col-md-3">
                <h3>Revenue</h3>
            </div>
        </div>
        @foreach($orders as $order)
            <div class="row">
                <div class="col-md-3">
                    <p>{{$order->product->name}}</p>
                </div>
                <div class="col-md-3">
                    <p>{{$order->product->category->name}}</p>
                </div>
                <div class="col-md-3">
                    <p>{{$order->quantity}}</p>
                </div>
                <div class="col-md-3">
                    <p>{{$order->price}}$</p>
                </div>
            </div>
        @endforeach
    </div>
@endsection