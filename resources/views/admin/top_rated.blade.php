@extends("layouts.vendor")
@section("title")
    Top rated products
@endsection

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-responsive table-hover">
                    <tr>
                        <th>No.</th>
                        <th>Name</th>
                        <th>Shop</th>
                        <th>Shop Email</th>
                        <th>Rate</th>
                    </tr>
                    @foreach($products as $product)
                        <tr>
                            <th>{{$loop->iteration}}</th>
                            <th>{{$product->name}}</th>
                            <th>{{$product->user->name}}</th>
                            <th>{{$product->user->email}}</th>
                            <th>{{$product->avg_rate}}</th>
                        </tr>
                    @endforeach
                </table>
                {!! $products->links() !!}
            </div>
        </div>
    </div>

@endsection