<?php

namespace App\Http\Controllers;

use App\BannerRequest;
use App\CartHistory;
use App\Category;
use App\CategoryRequest;
use App\Http\Requests\AboutRequest;
use App\Http\Requests\AdminRequest;
use App\Http\Requests\CatRequest;
use App\RegistrationRequest;
use App\Role;
use App\ShippingZone;
use App\UserDetail;
use App\FeaturedProduct;
use Illuminate\Http\Request;
use App\Http\Requests\OfferRequest;
use App\Offer;
use \Carbon\Carbon;
use App\Http\Controllers\MailController;
use App\FeaturedItem;
use App\User;
use App\About;
use App\Product;
use App\Comment;
use DB;

class AdminController extends Controller
{
    //================================= Constructor ==================================== //
    public function __construct()
    {
        $this->middleware(["admin.auth"]);
    }

    //=================================    Home     =====================================//

    /**
     * Home
     * The function is for rendering the home page for admin panel
     * @author: Mohamed Magdy
     * @return:  \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        return view('admin.index');
    }

    //=================================  Categories  ===================================== //

    /**
     * listCategories
     * The function uses Category model to list all categories
     * @author Mohamed Magdy
     * @return \Illuminate\Http\RedirectResponse
     */
    public function listCategories()
    {
        $cats = Category::all();
        return view('admin.all-categories', ['cats' => $cats]);
    }


    /**
     * newCategory
     * The function is used to render the view of creating new category
     * @author Mohamed Magdy
     * @return  \Illuminate\Http\RedirectResponse
     */

    public function newCategory()
    {
        return view('admin.new-category');
    }

    /**
     * createCategory
     * The function is used to receive the requests from new category view and save the data in the database
     * @author Mohamed Magdy
     * @param  CategoryRequest $request
     * @return  \Illuminate\Http\RedirectResponse
     */
    public function createCategory(CatRequest $request)
    {

        $cat = new Category();
        $cat->name = $request->name;
        $cat->save();
        return redirect('/admin/categories');

    }

    /**
     * editCategory
     * The function is used to render the view of editing existing category
     * @author Mohamed Magdy
     * @param Category $cat
     * @return  \Illuminate\Http\RedirectResponse
     */
    public function editCategory(Category $cat)
    {
        return view('admin.edit-category', compact('cat'));
    }

    /**
     * updateCategory
     * The function is used to receive the requests from edit category view and update this category in the database
     * @author Mohamed Magdy
     * @param Request $request
     * @param Category $category
     * @return  \Illuminate\Http\RedirectResponse
     */
    public function updateCategory(CatRequest $request , Category $cat)
    {
        $cat->update($request->all());
        return redirect('/admin/categories');
    }

    /**
     * deleteCategory
     * The function is used to delete specific category from the database records
     * @author Mohamed Magdy
     * @param  Request $request
     * @param Category $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteCategory(Request $request, Category $category)
    {
        $category->delete();
        return back();
    }

    //=================================  Registeration Requests  ===================================== //

    /**
     * viewALlRegRequests
     * The function is used to view all shop registeration requests
     * @author Mohamed Magdy
     * @param Request $request , RegistrationRequest $regReq
     * @return  \Illuminate\Http\RedirectResponse
     */
    public function viewAllRegRequests()
    {
        $regRequests = RegistrationRequest::all();
        return view('admin.all-registration-requests', ['regRequests' => $regRequests]);

    }

    /**
     * acceptRegRequest
     * The function is used to accept specific shop registeration request
     * @author Mohamed Magdy
     * @param Request $request
     * @param
     * @return  \Illuminate\Http\RedirectResponse
     */
    public function acceptRegRequest(Request $request, RegistrationRequest $regReq)
    {
//        $userDetails  = UserDetail::all();
//        dd($userDetails);
//        MailController::acceptRegistrationMail($regReq->user);
        $regReq->user->userDetails->status = '0';
        $regReq->user->userDetails->save();
        $regReq->delete();
        return back();
    }

    /**
     * rejectRegRequest
     * The function is used to reject specific shop registeration request
     * @author Mohamed Magdy
     * @param Request $request
     * @param RegistrationRequest $regReq
     * @return \Illuminate\Http\RedirectResponse
     */
    public function rejectRegRequest(Request $request, RegistrationRequest $regReq)
    {
        MailController::rejectRegistrationMail($regReq->user);
        $regReq->user->delete();
        $regReq->delete();
        return back();
    }

    //===========================================    Users  ====================================//

    public function listUsers()
    {
        if (\Auth::user()->hasRole('owner')) {
            $users = User::all()->where("id", "!=", \Auth::user()->id);

        } else {
            $users = User::whereHas('roles', function ($q) {
                $q->where('name', '!=', 'admin');
            })->get();

        }
        return view('admin.users', ['users' => $users]);
    }

    public function newAdminUser()
    {
        return view('admin.new-admin');
    }

    public function createAdminUser(AdminRequest $request)
    {
        $role = Role::all()->where("name", "=", "admin")->first();

        $user = new User;
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input("password"));
        $user->name = $request->input("name");
        $user->save();
        $user->roles()->attach($role);

        $userDetail = new UserDetail;
        $userDetail->date_of_birth = $request->input("date_of_birth");
        $userDetail->user()->associate($user);
        $userDetail->save();

        return back();
    }

    public function suspendUser(User $user)
    {
        if (\Auth::user()->hasRole('owner')) {
            $user->userDetails->status = '1';
            $user->userDetails->save();
        } else {
            if ($user->hasRole('employee') || $user->hasRole('shop') || $user->hasRole('customer')) {
                $user->userDetails->status = '1';
                $user->userDetails->save();
            }
        }

        return back();
    }

    public function blockUser(User $user)
    {
        if (\Auth::user()->hasRole('owner')) {
//            dd($user->userDetails);
            $user->userDetails->status = '2';
            $user->userDetails->save();
        } else {
            if ($user->hasRole('employee') || $user->hasRole('shop') || $user->hasRole('customer')) {
                $user->userDetails->status = '2';
                $user->userDetails->save();
            }
        }

        return back();
    }

    public function unsuspendUser(User $user)
    {
        if ($user->userDetails->status == '1') {
            if (\Auth::user()->hasRole('owner')) {
                $user->userDetails->status = '0';
                $user->userDetails->save();
            } else {
                if ($user->hasRole('employee') || $user->hasRole('shop') || $user->hasRole('customer')) {
                    $user->userDetails->status = '0';
                    $user->userDetails->save();
                }
            }
        }

        return back();
    }


    //============================================ Offers ==================================/

    public function showAddOfferForm()
    {
        return view("admin.new_offer");
    }

    public function addOffer(OfferRequest $request)
    {
        $offers = Offer::all();
        $incomingStartDate = Carbon::parse($request->input("start_date"));
        $incomingEndDate = Carbon::parse($request->input("end_date"));
        foreach ($offers as $offer) {
            $existingStartDate = Carbon::parse($offer->start_date);
            $existingEndDate = Carbon::parse($offer->end_date);
            if (!$existingStartDate->greaterThanOrEqualTo($incomingEndDate) && !$existingEndDate->lessThanOrEqualTo($incomingStartDate)) {
                return view("admin.new_offer")->withErrors([
                    "overlapping" => "This offer overlaps existing offer [" . $existingStartDate . " - " . $existingEndDate . "]"
                ]);
            }

        }
        Offer::create($request->all());
        return redirect(action("AdminController@index"));
    }

    public function viewFeaturedRequests()
    {
        $featuredRequests = FeaturedItem::all();
        return view("admin.featured_requests", [
            "featuredRequests" => $featuredRequests,
        ]);
    }

    public function acceptFeaturedRequest(FeaturedItem $item)
    {
        if (is_null(FeaturedProduct::find($item->product_id))) {
            $featuredProduct = new FeaturedProduct;
            $featuredProduct->product()->associate($item->product);
            $featuredProduct->save();
            $item->delete();
        }
        return back();
    }

    public function rejectFeaturedRequest(FeaturedItem $item)
    {
        $item->delete();
        return back();
    }

    //============================================ Category Requests ==================================/

    /**
     * viewAllCatCreationRequests
     * The function is used to view all shop category creation requests
     * @author Mohamed Magdy
     * @return  \Illuminate\Http\RedirectResponse
     */
    public function viewAllCatCreationRequests()
    {
        $catRequests = CategoryRequest::all();
        return view('admin.category-requests', ['catRequests' => $catRequests]);
    }

    /**
     * acceptCatCreationRequest
     * The function is used to accept specific shop category creation request
     * @author Mohamed Magdy
     * @param Request $request
     * @param CategoryCreationRequest $catReq
     * @return  \Illuminate\Http\RedirectResponse
     */
    public function acceptCatCreationRequest(Request $request, CategoryRequest $catReq)
    {
        $cat = new Category();
        $cat->name = $catReq->name;
        $cat->save();
        $catReq->delete();
        return back();
    }

    /**
     * rejectCatCreationRequest
     * The function is used to reject specific shop category creation request
     * @author Mohamed Magdy
     * @param Request $request
     * @param CategoryCreationRequest $catReq
     * @return \Illuminate\Http\RedirectResponse
     */
    public function rejectCatCreationRequest(Request $request, CategoryRequest $catReq)
    {
        $catReq->delete();
        return back();
    }


    // ====================================== Banner Requests ===================================//

    public function viewBannerRequests()
    {
        $bannerRequests = BannerRequest::all()->where('status', '==', false);
        return view("admin.banner_requests", [
            "bannerRequests" => $bannerRequests,
        ]);
    }

    public function acceptBannerRequest($id)
    {
        $item = BannerRequest::find($id);
        $item->status = true;
        $item->save();
        return back();
    }

    public function rejectBannerRequest($id)
    {
        $item = BannerRequest::find($id);
        $item->status = false;
        $item->save();
        return back();
    }

    public function mostProfitableProducts() {
        $products = Product::topProfit()->paginate(20);
        $total = Product::sum("revenue");
        if($total == 0)
            $total = 1;
        return view("admin.top_profit", [
            "products" => $products,
            "total" => $total
        ]);
    }

    public function mostProfitableCategories() {
        $categories = Product::select("category_id", DB::raw("sum(revenue) as total_revenue"))
            ->groupBy("category_id")
            ->orderBy("total_revenue", "desc")
            ->paginate(20);

        $total = Product::sum('revenue');
        if($total == 0)
            $total = 1;

        return view("admin.top_categories", [
            "categories" => $categories,
            "total" => $total
        ]);
    }

    public function mostProfitableCategoryProducts(Category $category) {
        $products = $category->products()->orderBy("revenue", "desc")->paginate(20);
        $total = $category->products()->sum("revenue");
        if($total == 0)
            $total = 1;
        return view("admin.top_category_products", [
            "products" => $products,
            "total" => $total,
        ]);
    }

    public function topRatedProducts()
    {
        $products = Product::orderBy("avg_rate", "desc")->paginate(20);

        return view("admin.top_rated", [
            "products" => $products
        ]);
    }

    public function topSellingProducts()
    {
        $products = Product::orderBy("sales_counter", "desc")->paginate(20);
        $total = Product::sum("sales_counter");
        if($total == 0)
            $total = 1;
        return view("admin.top_sale", [
            "products" => $products,
            "total" => $total
        ]);
    }

    public function topCategorySales()
    {
        $categories = Product::select("category_id", DB::raw('SUM(sales_counter) as sales'), DB::raw("sum(revenue) as revenue"))
            ->groupBy('category_id')
            ->orderBy('sales', 'DESC')
            ->paginate(20);
        $total = Product::sum('sales_counter');
        if($total == 0)
            $total = 1;
        return view("admin.top_categories", [
            "categories" => $categories,
            "total" => $total
        ]);
    }

    public function topSalesCategoryProducts(Category $category) {
        $products = $category->products()->orderBy("sales_counter", "desc")->paginate(20);
        $total = $category->products()->sum("sales_counter");
        if($total == 0)
            $total = 1;
        return view("admin.top_sales_category_products", [
            "products" => $products,
            "total" => $total,
        ]);
    }

    public function topSalesVendor() {
        $users = Product::select("user_id", DB::raw("sum(sales_counter) as sales"))
            ->groupBy("user_id")
            ->orderBy("sales", "desc")
            ->paginate(20);

        $total = Product::sum("sales_counter");

        if($total == 0)
            $total = 1;

        return view("admin.top_sales_vendor", [
            "users" => $users,
            "total" => $total
        ]);
    }

    public function topRevenueVendor() {
        $users = Product::select("user_id", DB::raw("sum(revenue) as revenue"))
            ->groupBy("user_id")
            ->orderBy("revenue", "desc")
            ->paginate(20);

        $total = Product::sum("revenue");

        if($total == 0)
            $total = 1;

        return view("admin.top_revenue_vendor", [
            "users" => $users,
            "total" => $total
        ]);
    }


    // ====================================== About ===================================//

    public function showAboutPage()
    {
        $aboutPage = About::all()->last();
        return view("admin.showAbout", [
            "aboutPage" => $aboutPage
        ]);
    }

    public function showEditAboutPage()
    {
        $aboutPage = About::all()->last();
        return view("admin.editAbout", [
            "aboutPage" => $aboutPage
        ]);
    }

    public function editAboutPage(AboutRequest $request, About $aboutPage)
    {
        $aboutPage->update($request->all());
        return redirect('/admin/about/show');

    }

    public function showMostReviwed()
    {

        $mostReviwed = DB::table('products')
            ->select('*')
            ->leftJoin(DB::raw('(SELECT item_id, COUNT(id) as CommentCount FROM laravellikecomment_comments
            GROUP BY (item_id) ) as T'), function ($join) {
                $join->on('T.item_id', '=', 'products.id');
            })
            ->paginate(20);

//        dd($mostReviwed);
        return view("admin.most_reviewed", [
            "mostReviwed" => $mostReviwed
        ]);
    }


    public function showNewShippingZoneForm() {
        return view("admin.new_shipping_zone");
    }

    public function showEditShippingZoneForm(ShippingZone $shippingZone) {
        return view("admin.edit_shipping_zone", [
            "zone" => $shippingZone
        ]);
    }

    public function newShippingZone(Request $request) {
        $this->validate($request, [
            "name" => "required|min:3"
        ]);
        $shippingZone = new ShippingZone;
        $shippingZone->name = $request->input("name");
        $shippingZone->save();
        return redirect()->action("AdminController@showShippingZones");
    }

    public function editShippingZone(Request $request, ShippingZone $shippingZone) {
        $this->validate($request, [
            "name" => "required|min:3"
        ]);

        $shippingZone->name = $request->input("name");
        $shippingZone->save();
        return redirect()->action("AdminController@showShippingZones");
    }

    public function showShippingZones() {
        $shippingZones = ShippingZone::all();
        return view("admin.shipping_zones", [
            "zones" => $shippingZones
        ]);
    }

    public function deleteShippingZone(ShippingZone $shippingZone) {
        $shippingZone->delete();
        return back();
    }

    public function previousOrders() {
        $orders = CartHistory::latest()->get();

        return view("admin.previous_orders", [
            "orders" => $orders
        ]);
    }

    public function orderDetails(CartHistory $order) {
        return view("admin.order_details", [
            "order" => $order
        ]);
    }

}
