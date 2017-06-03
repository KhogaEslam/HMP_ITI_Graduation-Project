@extends("layouts.vendor")
@section("title")
    Top sold products
@endsection

@section("content")
    <table class="table table-hover table-responsive">
        <tr>
            <th>No.</th>
            <th>Product name</th>
            <th>Category</th>
            <th>Revenue</th>
        </tr>
        @foreach($products as $product)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$product->name}}</td>
                <td>{{$product->category->name}}</td>
                <td>{{$product->revenue}}</td>
            </tr>
        @endforeach
    </table>
    {!! $product->links() !!}
@endsection