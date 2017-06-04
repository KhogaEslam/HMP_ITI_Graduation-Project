@extends("layouts.vendor")
@section("title")
    Top categories
@endsection

@section("content")
    <div class="container">
        <div class="col-md-12">
            <table class="table table-responsive table-hover">
                <tr>
                    <th>No.</th>
                    <th>Name</th>
                    <th>Revenue</th>
                </tr>
                @foreach($products as $product)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$product->category->name}}</td>
                        <td>{{$product->total_revenue}}$</td>
                    </tr>
                @endforeach
            </table>
            {!! $products->links() !!}
        </div>
    </div>
@endsection