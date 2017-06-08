@extends("layouts.admin")
@section("title")
    Top rated products
@endsection

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-5">
                <div class="list-group mb-5">
                    <h6 class="list-group-header">Product sales</h6>
                    @foreach($products as $product)
                        <a class="list-group-item list-group-item-action justify-content-between">
                            <span class="list-group-progress" style="width: {{$product->sales_counter / $total * 100}}%"></span>
                            {{$product->name}}
                            <span class="ml-a text-muted">{{round($product->sales_counter / $total * 100, 2)}}%</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                {{$products->links()}}
            </div>
        </div>
    </div>

@endsection