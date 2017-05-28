@extends("layouts.customer");
@section("title")
    {{\Auth::user()->name}} Shopping cart
@ends

@section("content")
    <table class="table table-responsive table-hover">
        <tr>
            <th>No.</th>
            <th>Product</th>
            <th>Quantity</th>
            <th>Unit price</th>
            <th>Total Price</th>
        </tr>
        @foreach($cartDetails as $cartDetail)
            <td>{{$loop->iteration}}</td>
            <td>{{$cartDetail->product->name}}</td>
        @endforeach
    </table>
@endsection