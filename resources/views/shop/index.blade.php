@forelse($categories as $category)
    <a href="{{action("VendorController@category", ["id" => $category->id])}}">{{$category->name}}</a><br>
@empty
    <h1 style="color: red">Empty Category</h1>
@endforelse