@forelse($products as $product)

@empty
    <h1 style="color: red;">No products yet</h1>
@endforelse

{!! link_to_action("VendorController@showNewProductForm", "New product", [$category->id]) !!}