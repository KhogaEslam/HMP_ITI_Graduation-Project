@forelse($products as $product)
{{link_to_action("VendorController@productDetails", $product->name, [$category->id, $product->id])}}
{{link_to_action("VendorController@showEditProductForm", "Edit", [$category->id, $product->id])}}
{!! Form::open(["action" => ["VendorController@deleteProduct", $category, $product]]) !!}
    {!! Form::submit("delete product") !!}
{!! Form::close() !!}
<br>
@empty
    <h1 style="color: red;">No products yet</h1>
@endforelse

{!! link_to_action("VendorController@showNewProductForm", "New product", [$category->id]) !!}