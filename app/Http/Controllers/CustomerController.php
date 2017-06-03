<?php

namespace App\Http\Controllers;

use App\ActiveBanner;
use App\CartDetail;
use App\ProductImage;
use App\Rating;
use App\WishList;
use App\FeaturedProduct;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

use App\Product;
use App\Category;
use \App\Http\Requests\CartRequest;
use App\Helpers\Trie;

class CustomerController extends Controller
{
    public function __construct() {
        $this->middleware("customer.auth")->except(["index", "products", "productDetails", "search", "searchPrefix"]);
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

        $bannerDetails = ActiveBanner::all();
        if(isset($bannerDetails->first()->banner))
            $bannerDetails = $bannerDetails->first()->banner;
        $category = 0;
        if(!isset($bannerDetails->type))
            $bannerDetails->type = 2;
        if($bannerDetails->type == 0){
            $category = Product::find($bannerDetails->connected_id)->category->id;
        }
        return view("customer.index", [
            "categories" => $categories,
            "inCart" => $inCart,
            "newArrivals" => $newArrivals,
            "featuredProducts" => $featuredProducts,
            "bestSellings" => $bestSellings,
            "banner" => $bannerDetails,
            "category" => $category,
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
        $isWish=WishList::where("product_id","=",$product->id)->first();

        if (\Auth::check() && \Auth::user()->hasRole("customer")) {
            $inCart = \Auth::user()->cart()->first()->cartDetails->count();
        }

        return view("customer.product_details", [
            "product" => $product,
            "category" => $category,
            "categories" => Category::all(),
            "inCart" => $inCart,
            "isWish" =>$isWish
        ]);
    }

    public function submitRating(Request $request , Product $product){
        $rating = new Rating();
        $rating->product()->associate($product);
        $rating->user()->associate(\Auth::user());
        $rating->rate = $request->star;
        $rating->save();
        $rating->product->avg_rate = $rating->product()->avg('rate');
        $rating->product->save();
        $rating->user->save();
        return back();
    }

    public function addToCart(CartRequest $request, Product $product) {

        $cartDetail = new CartDetail;

        $quantity = $request->input("quantity");
        $available = $cartDetail->product->quantity;

        if($quantity <= $available) {
            $cartDetail->product()->associate($product);
            $cartDetail->cart()->associate(\Auth::user()->cart);

            $cartDetail->quantity = $request->input("quantity");
            $cartDetail->save();
            return back();
        }
        else {
            return back()->withErrors([
                "quantity" => "Only " . $available . " items left in the shop"
            ]);
        }
    }

    public function editCart(CartRequest $request, CartDetail $cart) {
        $quantity = $request->input("quantity");
        $available = $cart->product->quantity;
        if($quantity <= $available) {
            $cart->quantity = $quantity;
            $cart->save();
            return back();
        }
        else {
            return back()->withErrors([
                "quantity" => "Only " . $available . " items left in the shop"
            ]);
        }
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


    public function search(Request $request) {
        $products = new \Illuminate\Database\Eloquent\Collection;
        $categories = Category::all();
        $search_name = $request->input("search_name");
//        dd($search_name);
        if(! empty($search_name)) {
            $products = Product::where('name', 'like', '%' . $search_name . '%')->get();
        }
        return view("customer.search_results", compact("products", "categories"));
    }

    public function searchPrefix(Request $request) {
        $trie = Trie::getInstance();
        $prefix = $request->input("prefix");
        return $trie->results($prefix, 20);
    }

}
