<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\SearchRequest;
use App\ProductSearch\ProductSearch;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function filter(SearchRequest $request)
    {

        $products = ProductSearch::apply($request);
        $categories = Category::all();
        $inCart = 0;
        $maxPrice = \DB::table('products')
            ->selectRaw('max(price) as max_price')
            ->first()->max_price;
        if (\Auth::check() && \Auth::user()->hasRole("customer")) {
            $inCart = \Auth::user()->cart()->first()->cartDetails->count();
        }
        return view("customer.products", [
            "categories" => $categories,
            "products" => $products,
            "inCart" => $inCart,
            "maxPrice" => $maxPrice,
            "pageHeading" => 'Search Results',
            "pageTitle" => 'Gadgetly | Search Results',
            "zeroResult" => 'There are no products matching your search'
        ]);
    }
}
