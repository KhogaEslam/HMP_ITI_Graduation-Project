<?php

namespace App\Http\Controllers;

use App\ActiveBanner;
use App\CartDetail;
use App\CartHistory;
use App\CurrentCheckout;
use App\Offer;
use App\ProductImage;
use App\ProductRate;
use App\WishList;
use App\About;
use App\FeaturedProduct;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use DB;
use App\Product;
use App\Category;
use \App\Http\Requests\CartRequest;
use App\Helpers\Trie;
use App\Helpers\PaypalIPN;
use App\Helpers\GuestCart;
use App\Http\Requests\CustomerRequest;

use SEOMeta;
use OpenGraph;
use Twitter;
## or
use SEO;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware("customer.auth")->except(["index", "verifyPayPalPayment", "catProducts", "productDetails", "search", "searchPrefix", "addToGuestCart", "viewGuestCart", "editGuestCart", "deleteFromGuestCart", "showAbout", "showContactUs"]);
    }

    public function index()
    {
        $categories = Category::all();

        if (\Auth::check() && \Auth::user()->hasRole("customer")) {
            $inCart = \Auth::user()->cart()->first()->cartDetails->count();
        } else {
            $inCart = GuestCart::getAllProductsCount(session("user.cart"));
        }
        $newArrivals = Product::latest('created_at')->limit(4)->published()->get();
        $featuredProducts = FeaturedProduct::all();
        $bestSelling = Product::orderBy('sales_counter', 'desc')->limit(4)->published()->get();

        $bannerDetails = ActiveBanner::all();
        if (isset($bannerDetails->first()->banner))
            $bannerDetails = $bannerDetails->first()->banner;
        $category = 0;
        if (!isset($bannerDetails->type))
            $bannerDetails->type = 2;
        if ($bannerDetails->type == 0) {
            $category = Product::find($bannerDetails->connected_id)->category->id;
        }

        /*
        * Start of SEO part of code
        * */
        $keywords = array();

        $categoriesArr = array_column($categories->toArray(), 'name');
        $keywords = array_merge($keywords, $categoriesArr);

        $newArrivalsArr = array_column($newArrivals->toArray(), 'name');
        $keywords = array_merge($keywords, $newArrivalsArr);

        $featuredProductsArr = array_column($featuredProducts->toArray(), 'name');
        $keywords = array_merge($keywords, $featuredProductsArr);

        $bestSellingArr = array_column($bestSelling->toArray(), 'name');
        $keywords = array_merge($keywords, $bestSellingArr);

        OpenGraph::addImage(route("banner", [$bannerDetails->image]));

        SEOMeta::setTitle('Gadgetly | Home');

        OpenGraph::setTitle('Gadgetly | Home');

        Twitter::setTitle('Gadgetly | Home');

        $keywords = array_unique($keywords);
        SEOMeta::addKeyword($keywords);

        /*
        * End of SEO
        * */

        return view("customer.index", [
            "categories" => $categories,
            "inCart" => $inCart,
            "newArrivals" => $newArrivals,
            "featuredProducts" => $featuredProducts,
            "bestSellings" => $bestSelling,
            "banner" => $bannerDetails,
            "category" => $category,
        ]);
    }

    public function catProducts(Category $category)
    {
        $products = $category->products()->published()->get();
        $categories = Category::all();

        $maxPrice = DB::table('products')
            ->selectRaw('max(price) as max_price')
            ->first()->max_price;

        if (\Auth::check() && \Auth::user()->hasRole("customer")) {
            $inCart = \Auth::user()->cart()->first()->cartDetails->count();
        } else {
            $inCart = GuestCart::getAllProductsCount(session("user.cart"));
        }

        /*
        * Start of SEO part of code
        * */
        $keywords = array();

        $categoriesArr = array_column($categories->toArray(), 'name');
        $keywords = array_merge($keywords, $categoriesArr);

        $productsArr = array_column($products->toArray(), 'name');
        $keywords = array_merge($keywords, $productsArr);

        SEOMeta::setTitle("Gadgetly | $category->name");

        OpenGraph::setTitle("Gadgetly | $category->name");

        Twitter::setTitle("Gadgetly | $category->name");

        foreach ($products as $product) {
            if (!$product->images()->get()->isEmpty())
                foreach ($product->images()->get() as $image)
                    OpenGraph::addImage(route("image", [$image->stored_name]));
        }

        $keywords = array_unique($keywords);
        SEOMeta::addKeyword($keywords);
        /*
        * End of SEO
        * */

        return view("customer.products", [
            "categories" => $categories,
            "products" => $products,
            "category" => $category,
            "inCart" => $inCart,
            "maxPrice" => $maxPrice,
            "pageHeading" => ucfirst($category->name) . " Products",
            "pageTitle" => "Gadgetly | " . strtoupper($category->name) . "Products",
            "zeroResult" => 'There are no products yet in the category',

        ]);
    }

    public function productDetails(Category $category, Product $product)
    {
        $categories = Category::all();
        $isWish = WishList::where("product_id", "=", $product->id)->first();

        if (\Auth::check() && \Auth::user()->hasRole("customer")) {
            $inCart = \Auth::user()->cart()->first()->cartDetails->count();
        } else {
            $inCart = GuestCart::getAllProductsCount(session("user.cart"));
        }

        /*
        * Start of SEO part of code
        * */
        $keywords = array();

        $categoriesArr = array_column($categories->toArray(), 'name');
        $keywords = array_merge($keywords, $categoriesArr);

        SEOMeta::setTitle("Gadgetly | $category->name | $product->name");
        SEOMeta::setDescription($product->description);

        OpenGraph::setTitle("Gadgetly | $category->name | $product->name");
        OpenGraph::setDescription($product->description);

        Twitter::setTitle("Gadgetly | $category->name | $product->name");

        if (!$product->images()->get()->isEmpty())
            foreach ($product->images()->get() as $image)
                OpenGraph::addImage(route("image", [$image->stored_name]));

        $descArr = explode(" ", $product->description);
        $keywords = array_merge($keywords, $descArr);

        $keywords = array_unique($keywords);
        SEOMeta::addKeyword($keywords);
        /*
        * End of SEO
        * */

        return view("customer.product_details", [
            "product" => $product,
            "category" => $category,
            "categories" => $categories,
            "inCart" => $inCart,
            "isWish" => $isWish
        ]);
    }

    public function submitRating(Request $request, Product $product)
    {
        $rating = new ProductRate();
        $rating->product()->associate($product);
        $rating->user()->associate(\Auth::user());
        $rating->rate = $request->star;
        $rating->save();
        $rating->product->avg_rate = round(DB::table('product_rates')
            ->select(DB::raw('avg(rate) as avg_rate'))
            ->groupBy('product_id')
            ->havingRaw("product_id = $product->id")->first()->avg_rate);
        $rating->product->save();
        return back();
    }

    public function addToCart(CartRequest $request, Product $product)
    {

        $cartDetail = new CartDetail;

        $quantity = $request->input("quantity");
        $available = $product->quantity;

        if ($quantity <= $available) {
            $cartDetail->product()->associate($product);
            $cartDetail->cart()->associate(\Auth::user()->cart);

            $cartDetail->quantity = $request->input("quantity");
            $cartDetail->save();
            return back();
        } else {
            return back()->withErrors([
                "quantity" => "Only " . $available . " items left in the shop"
            ]);
        }
    }

    public function editCart(CartRequest $request, CartDetail $cart)
    {
        $quantity = $request->input("quantity");
        $available = $cart->product->quantity;
        if ($quantity <= $available) {
            $cart->quantity = $quantity;
            $cart->save();
            return back();
        } else {
            return back()->withErrors([
                "quantity" => "Only " . $available . " items left in the shop"
            ]);
        }
    }

    public function viewCart()
    {
        $cartDetails = \Auth::user()->cart->cartDetails;
        $total = 0;

        foreach ($cartDetails as $cartDetail) {
            $total += ($cartDetail->product->price - $cartDetail->product->discount / 100.0 * $cartDetail->product->price) * $cartDetail->quantity;
        }
        $offer = Offer::current()->get();
        $final_total = $total;
        if (!$offer->isEmpty()) {
            $offer = $offer->first()->percentage;
            $final_total -= $final_total * $offer / 100.0;
        } else {
            $offer = 0;
        }
        if (\Auth::check()) {
            $inCart = \Auth::user()->cart()->first()->cartDetails->count();
        } else {
            $inCart = GuestCart::getAllProductsCount(session("user.cart"));
        }
        return view("customer.cart", [
            "cartDetails" => $cartDetails,
            "categories" => Category::all(),
            "total" => $total,
            "inCart" => $inCart,
            "final_total" => $final_total,
            "offer" => $offer,
        ]);
    }

    public function deleteProductFromCart(Request $request, CartDetail $cartDetail)
    {
        $cartDetail->delete();
        return back();
    }


    public function showWishList()
    {
//        $wishList=WishList::all()->where("user_id", "=", \Auth::user()->id);
        if (\Auth::check() && \Auth::user()->hasRole("customer")) {
            $inCart = \Auth::user()->cart()->first()->cartDetails->count();
        } else {
            $inCart = GuestCart::getAllProductsCount(session("user.cart"));
        }
        $wishList = \Auth::user()->wishlists;
        return view("customer.wishlist", [
            "wishList" => $wishList,
            "categories" => Category::all(),
            "inCart" => $inCart

        ]);

    }

    public function addToWishList($product)
    {
        $wishlist = new WishList();
        $wishlist->product_id = $product->id;
        $wishlist->user_id = \Auth::user()->id;
        $wishlist->save();

        return back();
    }

    public function deleteFromWishList(WishList $item)
    {
        $item->delete();
        return back();
    }

    public function addFeedBack()
    {
        return back();
    }


    public function search(Request $request)
    {
        $products = new \Illuminate\Database\Eloquent\Collection;
        $categories = Category::all();
        $search_name = $request->input("search_name");
        if (!empty($search_name)) {
            $products = Product::where('name', 'like', '%' . $search_name . '%')->get();
        }
        return view("customer.search_results", compact("products", "categories"));
    }

    public function searchPrefix(Request $request)
    {
        $trie = Trie::getInstance();
        $prefix = $request->input("prefix");
        return $trie->results($prefix, 20);
    }

    public function showPopularCategories()
    {
        $categories = DB::table("products")->select("category_id", DB::raw('SUM(sales_counter) as sales'))
            ->groupBy('category_id')
            ->orderBy('sales', 'DESC')
            ->get();

        return view("customer.popular_categories", [
            "categories" => $categories
        ]);
    }

    public function showAbout()
    {
        if (\Auth::check() && \Auth::user()->hasRole("customer")) {
            $inCart = \Auth::user()->cart()->first()->cartDetails->count();
        } else {
            $inCart = GuestCart::getAllProductsCount(session("user.cart"));
        }
        $aboutPage = About::all()->last();
        return view("customer.about", [
            "categories" => Category::all(),
            "aboutPage" => $aboutPage,
            "inCart" => $inCart
        ]);
    }

    public function cashCheckout()
    {
        $cart = \Auth::user()->cart;
        $items = $cart->cartDetails;
        foreach ($items as $item) {
            $product = $item->product;
            $price = round(($product->price - $product->price * $product->discount / 100) * $item->quantity, 2);
            $offer = Offer::current()->get();
            if ($offer->isEmpty()) {
                $offer = 0;
            } else {
                $offer = $offer->first()->percentage;
            }
            $price -= ($product->price * $offer) * $item->quantity;
            $checkout = new CurrentCheckout;
            $checkout->price = $price;
            $checkout->quantity += $item->quantity;
            $checkout->user()->associate(\Auth::user());
            $checkout->shop()->associate($product->user);
            $checkout->product()->associate($product);
            $checkout->save();
            $item->product->quantity -= $item->quantity;
            $item->product->sales_counter += $item->quantity;
            $item->revenue += $price;
            $item->product->save();
            $item->delete();
        }
        return back();
    }

    public function trackCheckout()
    {
        $orders = \Auth::user()->currentCheckouts()->paginate(20);
        if (\Auth::check() && \Auth::user()->hasRole("customer")) {
            $inCart = \Auth::user()->cart()->first()->cartDetails->count();
        } else {
            $inCart = GuestCart::getAllProductsCount(session("user.cart"));
        }
        $categories = Category::all();
        return view("customer.track_checkouts", [
            "categories" => $categories,
            "orders" => $orders,
            "inCart" => $inCart,
            "status" => [
                0 => ["Pending", "shop"],
                1 => ["Packaged", "shop"],
                2 => ["Verify receiving", "customer"],
                3 => ["Money on the way", "shop"],
                4 => ["Money received by shop", "shop"]
            ],
        ]);
    }

    public function changeCheckoutStatus(CurrentCheckout $checkout)
    {
        if ($checkout->user->id == \Auth::user()->id) {
            $checkout->status++;
            $checkout->save();
        }
        return back();
    }


    public function verifyPayPalPayment()
    {
        // Set this to true to use the sandbox endpoint during testing:
        $enable_sandbox = true;
        // Use this to specify all of the email addresses that you have attached to paypal:
        //"seller@paypalsandbox.com","buyer@paypalsandbox.com","mgmhardwaremarketplace@gmail.com","gbuyer@buyer.com","gbusiness@gadget.ly"
        $my_email_addresses = array();
        // Set this to true to send a confirmation email:
        $send_confirmation_email = false;
        $confirmation_email_address = "Gadgetly <mgmhardwaremarketplace@gmail.com>";
        $from_email_address = "Gadgetly <mgmhardwaremarketplace@gmail.com>";
        // Set this to true to save a log file:
        $save_log_file = true;
        $log_file_dir = __DIR__ . "/logs";
        // Here is some information on how to configure sendmail:
        // http://php.net/manual/en/function.mail.php#118210

        $ipn = new PaypalIPN();
        if ($enable_sandbox) {
            $ipn->useSandbox();
        }
        $verified = $ipn->verifyIPN();
        $data_text = "";
        foreach ($_POST as $key => $value) {
            $data_text .= $key . " = " . $value . "\r\n";
        }
        $test_text = "";
        if ($_POST["test_ipn"] == 1) {
            $test_text = "Test ";
        }
        // Check the receiver email to see if it matches your list of paypal email addresses
        $receiver_email_found = false;
        foreach ($my_email_addresses as $a) {
            if (strtolower($_POST["receiver_email"]) == strtolower($a)) {
                $receiver_email_found = true;
                break;
            }
        }
        date_default_timezone_set("Africa/Cairo");
        list($year, $month, $day, $hour, $minute, $second, $timezone) = explode(":", date("Y:m:d:H:i:s:T"));
        $date = $year . "-" . $month . "-" . $day;
        $timestamp = $date . " " . $hour . ":" . $minute . ":" . $second . " " . $timezone;
        $dated_log_file_dir = $log_file_dir . "/" . $year . "/" . $month;
        $paypal_ipn_status = "VERIFICATION FAILED";

        $cartID = 0;
        if (isset($_POST['custom'])) {
            if (is_int(intval($_POST['custom']))) {
                $cartID = intval($_POST['custom']);
            }
        }
        if ($verified) {
            $paypal_ipn_status = "RECEIVER EMAIL MISMATCH";
            if ($receiver_email_found) {
                $paypal_ipn_status = "Completed Successfully";
                // Process IPN
                // A list of variables are available here:
                // https://developer.paypal.com/webapps/developer/docs/classic/ipn/integration-guide/IPNandPDTVariables/
                // This is an example for sending an automated email to the customer when they purchases an item for a specific amount:
                if ($_POST["item_name"] == "Example Item" && $_POST["mc_gross"] == 49.99 && $_POST["mc_currency"] == "USD" && $_POST["payment_status"] == "Completed") {
                    $email_to = $_POST["first_name"] . " " . $_POST["last_name"] . " <" . $_POST["payer_email"] . ">";
                    $email_subject = $test_text . "Completed order for: " . $_POST["item_name"];
                    $email_body = "Thank you for purchasing " . $_POST["item_name"] . "." . "\r\n" . "\r\n" . "This is an example email only." . "\r\n" . "\r\n" . "Thank you.";
                    mail($email_to, $email_subject, $email_body, "From: " . $from_email_address);
                }
            }

            $ipn->checkout($cartID);
        } elseif ($enable_sandbox) {
            if ($_POST["test_ipn"] != 1) {
                $paypal_ipn_status = "RECEIVED FROM LIVE WHILE SANDBOXED";
            }
            $ipn->checkout($cartID);
        } elseif ($_POST["test_ipn"] == 1) {
            $paypal_ipn_status = "RECEIVED FROM SANDBOX WHILE LIVE";
            $ipn->checkout($cartID);
        }
        if ($save_log_file) {
            // Create log file directory
            if (!is_dir($dated_log_file_dir)) {
                if (!file_exists($dated_log_file_dir)) {
                    mkdir($dated_log_file_dir, 0777, true);
                    if (!is_dir($dated_log_file_dir)) {
                        $save_log_file = false;
                    }
                } else {
                    $save_log_file = false;
                }
            }
            // Restrict web access to files in the log file directory
            $htaccess_body = "RewriteEngine On" . "\r\n" . "RewriteRule .* - [L,R=404]";
            if ($save_log_file && (!is_file($log_file_dir . "/.htaccess") || file_get_contents($log_file_dir . "/.htaccess") !== $htaccess_body)) {
                if (!is_dir($log_file_dir . "/.htaccess")) {
                    file_put_contents($log_file_dir . "/.htaccess", $htaccess_body);
                    if (!is_file($log_file_dir . "/.htaccess") || file_get_contents($log_file_dir . "/.htaccess") !== $htaccess_body) {
                        $save_log_file = false;
                    }
                } else {
                    $save_log_file = false;
                }
            }
            if ($save_log_file) {
                // Save data to text file
                file_put_contents($dated_log_file_dir . "/" . $test_text . "paypal_ipn_" . $date . ".txt", "paypal_ipn_status = " . $paypal_ipn_status . "\r\n" . "paypal_ipn_date = " . $timestamp . "\r\n" . $data_text . "\r\n", FILE_APPEND);
            }
        }
        if ($send_confirmation_email) {
            // Send confirmation email
            mail($confirmation_email_address, $test_text . "PayPal IPN : " . $paypal_ipn_status, "paypal_ipn_status = " . $paypal_ipn_status . "\r\n" . "paypal_ipn_date = " . $timestamp . "\r\n" . $data_text, "From: " . $from_email_address);
        }
        // Reply with an empty 200 response to indicate to paypal the IPN was received correctly
        header("HTTP/1.1 200 OK");
    }

    public function showContactUs()
    {
        if (\Auth::check() && \Auth::user()->hasRole("customer")) {
            $inCart = \Auth::user()->cart()->first()->cartDetails->count();
        } else {
            $inCart = GuestCart::getAllProductsCount(session("user.cart"));
        }
        return view("customer.contactUs", [
            "categories" => Category::all(),
            "inCart" => $inCart
        ]);

    }

    public function addToGuestCart(Request $request, Product $product)
    {
        if (!session()->has("user.cart")) {
            session()->put("user.cart", []);
        }
        $cart = session("user.cart");
        if (!isset($cart[$product->id])) {
            $cart[$product->id] = 0;
        }
        $cart[$product->id] += $request->input("quantity");
        session()->put("user.cart", $cart);
        return back();
    }

    public function viewGuestCart()
    {
        $items = session("user.cart");
        if (is_null($items))
            $items = [];
        $cartDetails = new Collection();
        foreach ($items as $id => $quantity) {
            $product = Product::find($id);
            $cartDetail = new CartDetail;
            $cartDetail->quantity = $quantity;
            $cartDetail->product()->associate($product);
            $cartDetails->add($cartDetail);
        }

        $total = 0;
        $inCart = 0;

        foreach ($cartDetails as $cartDetail) {
            $total += ($cartDetail->product->price - $cartDetail->product->discount / 100.0 * $cartDetail->product->price) * $cartDetail->quantity;
        }
        $offer = Offer::current()->get();
        $final_total = $total;
        if (!$offer->isEmpty()) {
            $offer = $offer->first()->percentage;
            $final_total -= $final_total * $offer / 100.0;
        } else {
            $offer = 0;
        }
        if (\Auth::check()) {
            $inCart = \Auth::user()->cart()->first()->cartDetails->count();
        } else {
            $inCart = GuestCart::getAllProductsCount($items);
        }

        return view("customer.cart", [
            "cartDetails" => $cartDetails,
            "categories" => Category::all(),
            "total" => $total,
            "inCart" => $inCart,
            "final_total" => $final_total,
            "offer" => $offer,
        ]);
    }

    public function editGuestCart(Request $request, $id)
    {
        $cart = session("user.cart");
        $cart[$id] = $request->input("quantity");
        session()->put("user.cart", $cart);
        return back();
    }

    public function deleteFromGuestCart($id)
    {
        $cart = session("user.cart");
        unset($cart[$id]);
        session()->put("user.cart", $cart);
        return back();
    }

    public function viewProfile()
    {
        $user = \Auth::user();
        $categories = \App\Category::all();
        $inCart = \Auth::user()->cart()->first()->cartDetails->count();
        return view("customer.profile", [
            "user" => $user,
            "categories" => $categories,
            "inCart" => $inCart,
            "gender" => [
                "Male",
                "Female",
                "Other"
            ]
        ]);
    }

    public function showEditCustomerProfileForm()
    {
        $user = \Auth::user();
        $categories = \App\Category::all();
        $inCart = \Auth::user()->cart()->first()->cartDetails->count();
        return view("customer.edit_profile", [
            "user" => $user,
            "categories" => $categories,
            "inCart" => $inCart,
        ]);
    }

    public function editCustomerProfile(CustomerRequest $request)
    {
        $user = \Auth::user();
        $user->name = $request->input("name");
        $userDetail = $user->userDetails->first();
        $userDetail->date_of_birth = $request->input("date_of_birth");
        if ($request->has("password")) {
            $user->password = bcrypt($request->input("password"));
        }
        $userDetail->save();
        $user->save();
        return redirect()->action("CustomerController@viewProfile");
    }

    public function previousOrders()
    {
        $orders = CartHistory::buyer()->latest()->paginate(20);
        $categories = \App\Category::all();
        $inCart = \Auth::user()->cart()->first()->cartDetails->count();

        return view("customer.previous_orders", [
            "orders" => $orders,
            "inCart" => $inCart,
            "categories" => $categories,
        ]);
    }
}