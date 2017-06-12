@extends("layouts.admin")
@section("title")
    Top categories
@endsection

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-5">
                <h6 class="list-group-header">Best products in {{$products->first()->category->name}} (revenue)</h6>
                @foreach($products as $product)
                    <a class="list-group-item  list-group-item-action justify-content-between">
                        <span class="list-group-progress" style="width: {{$product->revenue / $total * 100}}%"></span>
                        {{$product->name}}
                        <span class="ml-a text-muted">{{round($product->revenue / $total * 100, 2)}}%</span>
                    </a>
                @endforeach
                {!! $products->links() !!}
            </div>
        </div>
    </div>
@endsection