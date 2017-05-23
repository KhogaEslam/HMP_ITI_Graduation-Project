<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return view("shop.index", [
            "categories" => $categories
        ]);
    }

    public function category(Category $category) {
        $products = $category->products;
        return view("shop.products", [
            "products" => $products,
            "category" => $category,
        ]);
    }

    public function showNewProductForm(Category $category) {
        return view("shop.new_product")->with("category", $category);
    }

    public function newProduct(Request $request, Category $category) {
        $product = new Product($request->all());
        $product->user()->associate(\Auth::user());
        $product->category()->associate($category);
        $product->save();
        return redirect()->action("Vendor@category", ["id" => $category->id]);
    }

    public function productDetails(Category $category, Product $product) {
        return view("shop.product", [
            "product" => $product,
            "category" => $category,
        ]);
    }


}
