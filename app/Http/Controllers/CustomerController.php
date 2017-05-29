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
        $inCart = \Auth::user()->cart()->first()->cartDetails->count();
        $newArrivals = Product::latest('created_at')->limit(4)->published()->get();
        return view("customer.index", [
            "categories" => $categories,
            "inCart" => $inCart,
            "newArrivals" => $newArrivals,
        ]);
    }

    public function products(Category $category) {
        $products = $category->products()->published()->get();
        $categories = Category::all();
        $inCart = \Auth::user()->cart()->first()->cartDetails->count();

        return view("customer.products", [
            "categories" => $categories,
            "products" => $products,
            "category" => $category,
            "inCart" => $inCart,
        ]);
    }

    public function productDetails(Category $category, Product $product) {
        $inCart = \Auth::user()->cart()->first()->cartDetails->count();

        return view("customer.product_details", [
            "product" => $product,
            "category" => $category,
            "categories" => Category::all(),
            "inCart" => $inCart,
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
        $total = 0;
        foreach($cartDetails as $cartDetail) {
            $total += ($cartDetail->product->price - $cartDetail->product->offer / 100.0 * $cartDetail->product->price - $cartDetail->product->discount / 100.0 * $cartDetail->product->price) * $cartDetail->quantity;
        }
        $inCart = \Auth::user()->cart()->first()->cartDetails->count();

        return view("customer.cart", [
            "cartDetails" => $cartDetails,
            "categories" => Category::all(),
            "total" => $total,
            "inCart" => $inCart,
        ]);
    }

    public function deleteProductFromCart(Request $request, CartDetail $cartDetail) {
        $cartDetail->delete();
        return back();
    }


    public function showWishList()
    {
        dd('hena');
    }
}
