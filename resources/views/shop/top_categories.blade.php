@extends("layouts.vendor")
@section("title")
    Top categories
@endsection

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                {{--<table class="table table-responsive table-hover">--}}
                    {{--<tr>--}}
                        {{--<th>No.</th>--}}
                        {{--<th>Name</th>--}}
                        {{--<th>Revenue</th>--}}
                    {{--</tr>--}}
                    {{--@foreach($products as $product)--}}
                        {{--<tr>--}}
                            {{--<td>{{$loop->iteration}}</td>--}}
                            {{--<td>{{$product->category->name}}</td>--}}
                            {{--<td>{{$product->total_revenue}}$</td>--}}
                        {{--</tr>--}}
                    {{--@endforeach--}}
                {{--</table>--}}
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-5">
                <h6 class="list-group-header">Categories</h6>
                @foreach($products as $product)
                    <a class="list-group-item  list-group-item-action justify-content-between">
                        <span class="list-group-progress" style="width: {{$product->total_revenue / $total * 100}}%"></span>
                        {{$product->category->name}}
                        <span class="ml-a text-muted">{{round($product->total_revenue / $total * 100, 2)}}%</span>
                    </a>
                @endforeach
                {!! $products->links() !!}
            </div>
        </div>
    </div>
@endsection