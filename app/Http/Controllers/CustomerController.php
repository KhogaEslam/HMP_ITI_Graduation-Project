<?php

namespace App\Http\Controllers;

use App\CartDetail;
use Illuminate\Http\Request;

use App\Product;
use App\Category;
use \App\Http\Requests\CartRequest;

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

    public function addToCart(CartRequest $request, Product $product) {
        $cartDetail = new CartDetail;

        $cartDetail->product()->associate($product);
        $cartDetail->cart()->associate(\Auth::user()->cart);

        $cartDetail->quantity = $request->input("quantity");
        $cartDetail->save();
        return back();
    }

    public function editCart(CartRequest $request, CartDetail $cart) {
        $cart->quantity = $request->input("quantity");
        $cart->save();
        return back();
    }

    public function viewCart() {
        $cartDetails = \Auth::user()->cart->cartDetails;
        dd($cartDetails);
    }
}
