@extends("layouts.vendor")
@section("title")
    Shop | Dashboard
@endsection
@section("content")
<div class="container">
    <div class="row">
        @forelse($categories as $category)

            <div class="col-sm-6 col-md-4">
                <div class="thumbnail">
                    <img src="http://placehold.it/235x235" alt="No image">
                    <div class="caption">
                        <h3>{{$category->name}}</h3>
                        <p><a class="btn btn-warning btn-block text-success" href="{{action("VendorController@category", ["id" => $category->id])}}">Browse</a></p>
                    </div>
                </div>
            </div>
        @empty
            <h1 class="text-lg-center text-danger">Empty Category</h1>
        @endforelse

    </div>


    <div class="row" style="padding-top: 30px;">
        <div class="col-md-12">
            {{$categories->links("vendor.pagination.bootstrap-4")}}
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <a class="btn btn-primary btn-block" href="/shop/category/new"> New Category </a>
        </div>
    </div>
</div>
@endsection