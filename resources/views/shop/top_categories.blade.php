@extends("layouts.vendor")
@section("title")
    Top categories
@endsection

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-5">
                <h6 class="list-group-header">Top categories (revenue)</h6>
                @foreach($categories as $category)
                    <a href="{{action("VendorController@mostProfitableCategoryProducts", [$category->category])}}" class="list-group-item  list-group-item-action justify-content-between">
                        <span class="list-group-progress" style="width: {{$category->total_revenue / $total * 100}}%"></span>
                        {{$category->category->name}}
                        <span class="ml-a text-muted">{{round($category->total_revenue / $total * 100, 2)}}%</span>
                    </a>
                @endforeach
                {!! $categories->links() !!}
            </div>
        </div>
    </div>
@endsection