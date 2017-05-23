@forelse($products as $product)
    {{link_to_action("CustomerController@productDetails", $product->name, [$category, $product])}}
@empty
    <p>No products in this category</p>
@endforelse