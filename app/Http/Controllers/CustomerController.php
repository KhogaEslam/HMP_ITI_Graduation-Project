<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Product;
use App\Category;

class CustomerController extends Controller
{
    public function index() {
        $categories = Category::all();
        return view("customer.index", [
            "categories" => $categories,
        ]);
    }

    public function products(Category $category) {
        $products = $category->products()->published()->get();
        $categories = Category::all();
        return view("customer.products", [
            "categories" => $categories,
            "products" => $products,
            "category" => $category,
        ]);
    }

    public function productDetails(Category $category, Product $product) {
        return view("customer.product_details", [
            "product" => $product,
            "category" => $category,
        ]);
    }
}
