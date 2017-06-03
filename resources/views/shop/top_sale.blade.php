@extends("layouts.vendor")
@section("title")
    Top sold products
@endsection

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-md-12">
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
                {!! $products->links() !!}
            </div>
        </div>
    </div>
@endsection