@forelse($categories as $category)
    {{link_to_action("CustomerController@products", $category->name, [$category])}}<br>
@empty
    <p>No categories yet</p>
@endforelse