<?php

namespace App\Http\Controllers;

use App\CartDetail;
use App\WishList;
use App\FeaturedProduct;
use Illuminate\Http\Request;

use App\Product;
use App\Category;
use \App\Http\Requests\CartRequest;

class CustomerController extends Controller
{
    public function __construct() {
        $this->middleware("customer.auth")->except(["index", "products", "productDetails"]);
    }

    public function index()
    {
        $categories = Category::all();
        $inCart = 0;
        if (\Auth::check() && \Auth::user()->hasRole("customer")) {
            $inCart = \Auth::user()->cart()->first()->cartDetails->count();
        }
        $newArrivals = Product::latest('created_at')->limit(4)->published()->get();
        $featuredProducts = FeaturedProduct::all();
        $bestSellings = Product::orderBy('sales_counter','desc')->limit(4)->published()->get();

        return view("customer.index", [
            "categories" => $categories,
            "inCart" => $inCart,
            "newArrivals" => $newArrivals,
            "featuredProducts" => $featuredProducts,
            "bestSellings" => $bestSellings,
        ]);
    }

    public function products(Category $category) {
        $products = $category->products()->published()->get();
        $categories = Category::all();
        $inCart = 0;
        if (\Auth::check() && \Auth::user()->hasRole("customer")) {
            $inCart = \Auth::user()->cart()->first()->cartDetails->count();
        }
        return view("customer.products", [
            "categories" => $categories,
            "products" => $products,
            "category" => $category,
            "inCart" => $inCart,
        ]);
    }

    public function productDetails(Category $category, Product $product) {
        $inCart = 0;

        if (\Auth::check() && \Auth::user()->hasRole("customer")) {
            $inCart = \Auth::user()->cart()->first()->cartDetails->count();
        }

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
        $inCart = 0;

        foreach($cartDetails as $cartDetail) {
            $total += ($cartDetail->product->price - $cartDetail->product->offer / 100.0 * $cartDetail->product->price - $cartDetail->product->discount / 100.0 * $cartDetail->product->price) * $cartDetail->quantity;
        }

        if (\Auth::check()) {
            $inCart = \Auth::user()->cart()->first()->cartDetails->count();
        }

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
//        $wishList=WishList::all()->where("user_id", "=", \Auth::user()->id);
        $wishList=\Auth::user()->wishlists;
        return view("customer.wishlist", [
            "wishList" => $wishList,
            "categories" => Category::all(),

        ]);

    }

    public function addToWishList($product)
    {
        $wishlist=new WishList();
        $wishlist->product_id=$product->id;
        $wishlist->user_id=\Auth::user()->id;
        $wishlist->save();

        return back();
    }

    public function deleteFromWishList(WishList $item)
    {
        $item->delete();
        return back();
    }

}
