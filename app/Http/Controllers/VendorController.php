<?php

namespace App\Http\Controllers;

use App\CartHistory;
use App\CategoryRequest;
use App\CurrentCheckout;
use App\Http\Requests\BannerRequest;
use App\Http\Requests\CatRequest;
use App\ProductImage;
use App\User;
use App\UserDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Category;
use App\Product;
use App\Discount;
use App\FeaturedItem;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Employee;
use \App\Role;
use \App\Http\Requests\EmployeeRequest;
use \App\Http\Requests\EditEmployeeRequest;
use \App\Helpers\Trie;
use \App\UserAddress;
use \App\UserPhone;
use DB;

class VendorController extends Controller
{

    public function __construct()
    {
        $this->middleware(["employee.auth"]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $user = \Auth::user();
        if(!$user->employee()->get()->isEmpty()) {
            $user = $user->employee->first()->manager;
        }
        if($user->plan()->get()->isEmpty()){
            return redirect()->route('payPremium');
        }

        $categories = Category::paginate(9);
        return view("shop.index", [
            "categories" => $categories
        ]);
    }

    /**
     * newCategory
     * The function is used to render the view of creating new category
     * @author Mohamed Magdy
     * @return  \Illuminate\Http\RedirectResponse
     */

    public function newCategory()
    {

        $user = \Auth::user();
        if(!$user->employee()->get()->isEmpty()) {
            $user = $user->employee->first()->manager;
        }
        if($user->plan()->get()->isEmpty()){
            return redirect()->route('payPremium');
        }

        return view( 'shop.new-category');
    }

    /**
     * createCategory
     * The function is used to receive the requests from new category view and save the data in the database
     * @author Mohamed Magdy
     * @param  Request $request
     * @return  \Illuminate\Http\RedirectResponse
     */
    public function requestCategory( Request $request)
    {
        $this->validate($request, [
            "name" => "required|unique:categories|unique:category_requests|string|min:2|max:50"
        ]);
        $user = \Auth::user();
        if(!$user->employee()->get()->isEmpty()) {
            $user = $user->employee->first()->manager;
        }

        if($user->plan()->get()->isEmpty()){
            return redirect()->route('payPremium');
        }


        $catRequest = new CategoryRequest();
        $catRequest->name = $request->name;
        $catRequest->user()->associate($user);
        $catRequest->save();
        return redirect()->action("VendorController@index");
    }

    /**
     * Listing all the products inside certain category that belongs to the current shop
     * @param Category $category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function category(Category $category)
    {
        $user = \Auth::user();
        if(!$user->employee()->get()->isEmpty()) {
            $user = $user->employee->first()->manager;
        }

        if($user->plan()->get()->isEmpty()){
            return redirect()->route('payPremium');
        }

        $products = $category->products()->owned()->paginate(5);
        return view("shop.products", [
            "products" => $products,
            "category" => $category,
        ]);
    }

    /**
     * Returning new product form
     * @param Category $category
     * @return $this
     */

    public function showNewProductForm(Category $category) {
        $user = \Auth::user();
        if(!$user->employee()->get()->isEmpty()) {
            $user = $user->employee->first()->manager;
        }

        if($user->plan()->get()->isEmpty()){
            return redirect()->route('payPremium');
        }

        return view("shop.new_product", [
            "category" => $category,
        ]);
    }

    /**
     * @param Request $request
     * @param Category $category
     * @return \Illuminate\Http\RedirectResponse
     */

    public function newProduct(Request $request, Category $category)
    {
        $user = \Auth::user();
        if(!$user->employee()->get()->isEmpty()) {
            $user = $user->employee->first()->manager;
        }

        if($user->plan()->get()->isEmpty()){
            return redirect()->route('payPremium');
        }

        $user = \Auth::user();
        if(\Auth::user()->hasRole("employee")) {
            $user = $user->employee->where("employee_id", "=", $user->id)->first()->manager;
        }
        $upload_to = resource_path("img");
        $product = new Product($request->all());
        $product->user()->associate($user);
        $product->category()->associate($category);
        $product->save();
        $files = $request->images;
        $files_count = count($files);
        $uploaded_files = 0;
        if($files_count > 0) {
            foreach ($files as $file) {
                $rules = array('file' => 'mimes:png,jpeg');
                $validator = Validator::make(array('file' => $file), $rules);
                if ($validator->passes()) {
                    $filename = $file->getClientOriginalName();
                    $fileNameStored = sha1(\Auth::user()->email . (string)time() . $filename);
                    $upload_success = $file->move($upload_to, $fileNameStored);
                    $productImage = new ProductImage;
                    $productImage->image_name = $filename;
                    $productImage->stored_name = $fileNameStored;
                    $productImage->product()->associate($product);
                    $productImage->save();
                    $uploaded_files++;
                }
            }
        }
        if ($uploaded_files == $files_count) {
            return redirect()->action("VendorController@category", [$category->id]);
        } else {
            return back()->withInput()->withErrors($validator);
        }
    }

    public function productDetails(Category $category, Product $product)
    {
        $user = \Auth::user();
        if(!$user->employee()->get()->isEmpty()) {
            $user = $user->employee->first()->manager;
        }

        if($user->plan()->get()->isEmpty()){
            return redirect()->route('payPremium');
        }

        $discount=Discount::where("product_id","=",$product->id)->first();
        $featuredItem=FeaturedItem::where("product_id","=",$product->id)->first();
        return view("shop.product", [
            "product" => $product,
            "category" => $category,
            "discount" => $discount,
            "featuredItem" => $featuredItem
        ]);
    }

    public function showEditProductForm(Category $category, Product $product)
    {
        $user = \Auth::user();
        if(!$user->employee()->get()->isEmpty()) {
            $user = $user->employee->first()->manager;
        }

        if($user->plan()->get()->isEmpty()){
            return redirect()->route('payPremium');
        }

        return view("shop.edit_product", compact("category", "product"));
    }

    public function editProduct(Request $request, Category $category, Product $product)
    {
        $user = \Auth::user();
        if(!$user->employee()->get()->isEmpty()) {
            $user = $user->employee->first()->manager;
        }

        if($user->plan()->get()->isEmpty()){
            return redirect()->route('payPremium');
        }

        $user = \Auth::user();
        if($user->hasRole("employee")) {
            $user->employee->where("employee_id", "=", $user->id)->first()->manager;
        }
        if($product->user->id == $user->id) {
            $upload_to = resource_path("img");
            Trie::getInstance()->deleteProduct($product->name);
            $product->update($request->all());
            Trie::getInstance()->addProduct($product->name);
            $files = $request->images;
            $files_count = count($files);
            $uploaded_files = 0;
            if($files_count > 0) {
                foreach ($files as $file) {
                    $rules = array('file' => 'mimes:png,jpeg');
                    $validator = Validator::make(array('file' => $file), $rules);
                    if ($validator->passes()) {
                        $filename = $file->getClientOriginalName();
                        $fileNameStored = sha1(\Auth::user()->email . (string)time() . $filename);
                        $upload_success = $file->move($upload_to, $fileNameStored);
                        $productImage = new ProductImage;
                        $productImage->image_name = $filename;
                        $productImage->stored_name = $fileNameStored;
                        $productImage->product()->associate($product);
                        $productImage->save();
                        $uploaded_files++;
                    }
                }
            }
            if ($uploaded_files == $files_count) {
                return redirect()->action("VendorController@productDetails", ["category" => $category, "product" => $product]);
            } else {
                return back()->withInput()->withErrors($validator);
            }

        }
    }

    public function deleteProduct(Category $category, Product $product)
    {
        $user = \Auth::user();
        if(!$user->employee()->get()->isEmpty()) {
            $user = $user->employee->first()->manager;
        }

        if($user->plan()->get()->isEmpty()){
            return redirect()->route('payPremium');
        }

        if($product->user->id == $user->id) {
            Trie::getInstance()->deleteProduct($product->name);
            $product->delete();
            return back();
        }
        else {
            return response("You're forbidden", 403);
        }
    }

    public function publishProduct(Category $category, Product $product)
    {
        $user = \Auth::user();
        if(!$user->employee()->get()->isEmpty()) {
            $user = $user->employee->first()->manager;
        }

        if($user->plan()->get()->isEmpty()){
            return redirect()->route('payPremium');
        }

        if($product->user->id == $user->id) {
            $product->published = true;
            Trie::getInstance()->addProduct($product->name);
            $product->save();
            return back();
        }
        else {
            return response("Access forbidden", 403);
        }
    }

    public function unPublishProduct(Category $category, Product $product)
    {
        $user = \Auth::user();
        if(!$user->employee()->get()->isEmpty()) {
            $user = $user->employee->first()->manager;
        }

        if($user->plan()->get()->isEmpty()){
            return redirect()->route('payPremium');
        }

        if($product->user->id == $user->id) {
            $product->published = false;
            Trie::getInstance()->deleteProduct($product->name);
            $product->save();
            return back();
        }
        else {
            return response("Access forbidden", 403);
        }
    }

    public function showNewEmployeeForm() {
        $user = \Auth::user();
        if(!$user->employee()->get()->isEmpty()) {
            $user = $user->employee->first()->manager;
        }

        if($user->plan()->get()->isEmpty()){
            return redirect()->route('payPremium');
        }

        return view("shop.new_employee");
    }

    public function newEmployee(EmployeeRequest $request) {

        $user = \Auth::user();
        if(!$user->employee()->get()->isEmpty()) {
            $user = $user->employee->first()->manager;
        }

        if($user->plan()->get()->isEmpty()){
            return redirect()->route('payPremium');
        }

        $role = Role::all()->where("name", "=", "employee")->first();

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

        $employee = new Employee;
        $employee->manager()->associate(\Auth::user());
        $employee->self()->associate($user);
        $employee->save();

        return redirect()->action("VendorController@showEmployees");
    }

    public function showEditEmployeeForm(Employee $employee) {
        $user = \Auth::user();
        if(!$user->employee()->get()->isEmpty()) {
            $user = $user->employee->first()->manager;
        }

        if($user->plan()->get()->isEmpty()){
            return redirect()->route('payPremium');
        }

        return view("shop.edit_employee", ["employee" => $employee]);
    }

    public function editEmployee(EditEmployeeRequest $request, Employee $employee) {
        $user = \Auth::user();
        if(!$user->employee()->get()->isEmpty()) {
            $user = $user->employee->first()->manager;
        }

        if(\Auth::user()->id == $employee->manager->id) {
            $employee = $employee->self;
            $name = $request->input("name");
            $password = $request->input("password");
            $date_of_birth = $request->input("date_of_birth");
            if (isset($name)) {
                $employee->name = $name;
            }
            if (isset($password)) {
                $employee->password = bcrypt($password);
            }
            if (isset($date_of_birth)) {
                $employee->userDetails->date_of_birth = $date_of_birth;
                $employee->userDetails->save();
            }
            $employee->save();
            return redirect()->action("VendorController@showEmployees");
        }
        else {
            return response("You're not authenticated", 403);
        }
    }

    public function deleteEmployee(Request $request, Employee $employee) {
        $user = \Auth::user();
        if(!$user->employee()->get()->isEmpty()) {
            $user = $user->employee->first()->manager;
        }

        if($user->plan()->get()->isEmpty()){
            return redirect()->route('payPremium');
        }

        if(\Auth::user()->id == $employee->manager->id) {
            $employee->self->delete();
        }
    }

    public function showEmployees() {
        $user = \Auth::user();
        if(!$user->employee()->get()->isEmpty()) {
            $user = $user->employee->first()->manager;
        }

        if($user->plan()->get()->isEmpty()){
            return redirect()->route('payPremium');
        }

        $employees = Employee::all()->where("manager_id", "=", \Auth::user()->id);
        return view("shop.employees", [
            "employees" => $employees
        ]);
    }


    public function showDiscountProductForm(Product $product)
    {
        $user = \Auth::user();
        if(!$user->employee()->get()->isEmpty()) {
            $user = $user->employee->first()->manager;
        }

        if($user->plan()->get()->isEmpty()){
            return redirect()->route('payPremium');
        }

        return view("shop.add_discount",[
            'product' => $product
        ]);
    }

    public function newDiscount(Request $request, Product $product)
    {
        $user = \Auth::user();
        if(!$user->employee()->get()->isEmpty()) {
            $user = $user->employee->first()->manager;
        }

        if($user->plan()->get()->isEmpty()){
            return redirect()->route('payPremium');
        }

        $discount=new Discount();
        $discount->percentage = $request->input('percentage');
        $discount->start_date = $request->input('start_date');
        $discount->end_date = $request->input('end_date');
        $discount->product_id = $product->id;
        $discount->save();

        return redirect()->action("VendorController@productDetails", ["category" => $product->category_id, "product" => $product]);

//        return redirect()->action("VendorController@category",[$product->category_id]);

    }

    public function deleteDiscount(Discount $discount)
    {
        $user = \Auth::user();
        if(!$user->employee()->get()->isEmpty()) {
            $user = $user->employee->first()->manager;
        }

        if($user->plan()->get()->isEmpty()){
            return redirect()->route('payPremium');
        }

        $discount->delete();
            return back();
    }

    public function makeFeaturedItemRequest($product)
    {
        $user = \Auth::user();
        if(!$user->employee()->get()->isEmpty()) {
            $user = $user->employee->first()->manager;
        }

        if($user->plan()->get()->isEmpty()){
            return redirect()->route('payPremium');
        }

        $featuredItem = new FeaturedItem();
        $featuredItem->product_id = $product->id;
        $featuredItem->user_id = $user->id;
        $featuredItem->save();
        return back();
    }

    public function showBannerRequestForm() {
        $user = \Auth::user();
        if(!$user->employee()->get()->isEmpty()) {
            $user = $user->employee->first()->manager;
        }

        if($user->plan()->get()->isEmpty()){
            return redirect()->route('payPremium');
        }

        $products = Product::owned()->get()->pluck("name", "id");
        return view("shop.banner_request", compact("products"));
    }

    public function addBannerRequest(BannerRequest $request) {
        $user = \Auth::user();
        if(!$user->employee()->get()->isEmpty()) {
            $user = $user->employee->first()->manager;
        }

        if($user->plan()->get()->isEmpty()){
            return redirect()->route('payPremium');
        }

        $products = Product::owned()->get()->pluck("name", "id");
        $upload_to = resource_path("banner");

        $banners = \App\BannerRequest::all();
        $incomingStartDate = Carbon::parse($request->input("start_date"));
        $incomingEndDate = Carbon::parse($request->input("end_date"));
        foreach($banners as $banner) {
            $existingStartDate = Carbon::parse($banner->start_date);
            $existingEndDate = Carbon::parse($banner->end_date);
            if(! $existingStartDate->greaterThanOrEqualTo($incomingEndDate) && ! $existingEndDate->lessThanOrEqualTo($incomingStartDate)) {
                return view("shop.banner_request", compact("products"))->withErrors([
                    "overlapping" => "This request overlaps another [" . $existingStartDate . " - " . $existingEndDate . "]"
                ]);
            }

        }
        $banner = new \App\BannerRequest;
        $banner->start_date = $request->input("start_date");
        $banner->end_date = $request->input("end_date");
        $banner->status = 0;
        $file = $request->file("image");
        $banner->image = sha1(\Auth::user()->email . (string)time() . $file->getClientOriginalName());
        $file->move($upload_to, $banner->image);

        $banner->type = $request->input("type");
        if($banner->type == 0) {
            $banner->connected_id = $request->input("product");
        }
        else if($banner->type == 1) {
            $banner->connected_id = $user->id;
        }
        $banner->save();
        return redirect(action("VendorController@index"));
    }

    public function mostSoldProducts() {
        $user = \Auth::user();
        if(!$user->employee()->get()->isEmpty()) {
            $user = $user->employee->first()->manager;
        }

        if($user->plan()->get()->isEmpty()){
            return redirect()->route('payPremium');
        }


        $products = Product::owned()->topSale()->paginate(20);
        $total = Product::owned()->sum("sales_counter");
        if($total == 0)
            $total = 1;
        return view("shop.top_sale", [
            "products" => $products,
            "total" => $total
        ]);
    }

    public function mostProfitableProducts() {
        $user = \Auth::user();
        if(!$user->employee()->get()->isEmpty()) {
            $user = $user->employee->first()->manager;
        }

        if($user->plan()->get()->isEmpty()){
            return redirect()->route('payPremium');
        }

        $products = Product::owned()->topProfit()->paginate(20);
        $total = Product::owned()->sum("revenue");
        if($total == 0)
            $total = 1;
        return view("shop.top_profit", [
            "products" => $products,
            "total" => $total
        ]);
    }

    public function mostProfitableCategories() {
        $user = \Auth::user();
        if(!$user->employee()->get()->isEmpty()) {
            $user = $user->employee->first()->manager;
        }

        if($user->plan()->get()->isEmpty()){
            return redirect()->route('payPremium');
        }

        $categories = Product::owned()
            ->select("category_id", DB::raw("sum(revenue) as total_revenue"))
            ->groupBy("category_id")
            ->orderBy("total_revenue", "desc")
            ->paginate(20);

        $total = Product::owned()->sum('revenue');
        if($total == 0)
            $total = 1;


        return view("shop.top_categories", [
            "categories" => $categories,
            "total" => $total
        ]);
    }

    public function mostProfitableCategoryProducts(Category $category) {
        $user = \Auth::user();
        if(!$user->employee()->get()->isEmpty()) {
            $user = $user->employee->first()->manager;
        }

        if($user->plan()->get()->isEmpty()){
            return redirect()->route('payPremium');
        }

        $products = $category->products()->owned()->orderBy("revenue", "desc")->paginate(20);
        $total = $category->products()->owned()->sum("revenue");
//                dd($products);
        if($total == 0)
            $total = 1;
        return view("shop.top_category_products", [
            "products" => $products,
            "total" => $total,
        ]);
    }

    public function topSalesCategories() {
        $user = \Auth::user();
        if(!$user->employee()->get()->isEmpty()) {
            $user = $user->employee->first()->manager;
        }

        if($user->plan()->get()->isEmpty()){
            return redirect()->route('payPremium');
        }

        $categories = Product::owned()
            ->select("category_id", DB::raw("sum(sales_counter) as sales"))
            ->groupBy("category_id")
            ->orderBy("sales", "desc")
            ->paginate(20);

        $total = Product::owned()->sum('sales_counter');
        if($total == 0)
            $total = 1;

        return view("shop.top_sales_categories", [
            "categories" => $categories,
            "total" => $total
        ]);
    }


    public function topSalesCategoryProducts(Category $category) {
        $user = \Auth::user();
        if(!$user->employee()->get()->isEmpty()) {
            $user = $user->employee->first()->manager;
        }

        if($user->plan()->get()->isEmpty()){
            return redirect()->route('payPremium');
        }

        $products = $category->products()->owned()->orderBy("sales_counter", "desc")->paginate(20);
        $total = $category->products()->owned()->sum("sales_counter");
        if($total == 0)
            $total = 1;
        return view("shop.top_sales_category_products", [
            "products" => $products,
            "total" => $total,
        ]);
    }

    public function topRatedProducts() {
        $user = \Auth::user();
        if(!$user->employee()->get()->isEmpty()) {
            $user = $user->employee->first()->manager;
        }

        if($user->plan()->get()->isEmpty()){
            return redirect()->route('payPremium');
        }

        $products = Product::owned()->orderBy("avg_rate", "desc")->paginate(20);
        return view("shop.top_rated_products", [
            "products" => $products,
        ]);
    }

    public function showNewAddressesForm() {
        $user = \Auth::user();
        if(!$user->employee()->get()->isEmpty()) {
            $user = $user->employee->first()->manager;
        }

        if($user->plan()->get()->isEmpty()){
            return redirect()->route('payPremium');
        }

        $addresses = $user->addresses;
        $counter = $addresses->count();
        if($counter == 0)
            $counter++;
        return view("shop.new_addresses", [
            "addresses" => $addresses,
        ]);
    }

    public function showNewPhonesForm() {
        $user = \Auth::user();
        if(!$user->employee()->get()->isEmpty()) {
            $user = $user->employee->first()->manager;
        }

        if($user->plan()->get()->isEmpty()){
            return redirect()->route('payPremium');
        }

        $phones = $user->phones;
        return view("shop.new_phones", [
            "phones" => $phones
        ]);
    }

    public function newAddress(Request $request) {
        $user = \Auth::user();
        if(!$user->employee()->get()->isEmpty()) {
            $user = $user->employee->first()->manager;
        }

        if($user->plan()->get()->isEmpty()){
            return redirect()->route('payPremium');
        }

        $this->validate($request, [
            "addresses" => "required",
            "addresses.*" => "required"
        ]);
        $addresses = $request->input("addresses");
        foreach($addresses as $address) {
            $userAddress = new UserAddress;
            $userAddress->address = $address;
            $userAddress->user()->associate($user);
            $userAddress->save();
        }
        return redirect()->action("VendorController@addresses");
    }

    public function deleteAddress(UserAddress $address) {
        $user = \Auth::user();
        if(!$user->employee()->get()->isEmpty()) {
            $user = $user->employee->first()->manager;
        }

        if($user->plan()->get()->isEmpty()){
            return redirect()->route('payPremium');
        }

        if($address->user_id == $user->id) {
            $address->delete();
        }
        return back();
    }

    public function addresses() {
        $user = \Auth::user();
        if(!$user->employee()->get()->isEmpty()) {
            $user = $user->employee->first()->manager;
        }

        if($user->plan()->get()->isEmpty()){
            return redirect()->route('payPremium');
        }

        $addresses = $user->addresses()->paginate(20);
        return view("shop.addresses", [
            "addresses" => $addresses
        ]);
    }

    public function newPhones(Request $request) {
        $user = \Auth::user();
        if(!$user->employee()->get()->isEmpty()) {
            $user = $user->employee->first()->manager;
        }

        if($user->plan()->get()->isEmpty()){
            return redirect()->route('payPremium');
        }

        $this->validate($request, [
            "new_phones" => "required",
            "new_phones.*" => "required|regex:/(01)[0-9]{9}/",
        ]);
        $phones = $request->input("new_phones");
        foreach($phones as $phone) {
            $userPhone = new UserPhone;
            $userPhone->number = $phone;
            $userPhone->user()->associate($user);
            $userPhone->save();
        }
        return redirect()->action("VendorController@phones");
    }

    public function phones() {
        $user = \Auth::user();
        if(!$user->employee()->get()->isEmpty()) {
            $user = $user->employee->first()->manager;
        }

        if($user->plan()->get()->isEmpty()){
            return redirect()->route('payPremium');
        }

        $phones = $user->phones()->paginate(20);
        return view("shop.phones", [
            "phones" => $phones
        ]);
    }

    public function deletePhone(UserPhone $phone) {
        $user = \Auth::user();
        if(!$user->employee()->get()->isEmpty()) {
            $user = $user->employee->first()->manager;
        }

        if($user->plan()->get()->isEmpty()){
            return redirect()->route('payPremium');
        }

        if($phone->user_id == \Auth::user()->id) {
            $phone->delete();
        }
        return back();
    }

    public function viewCheckouts() {
        $user = \Auth::user();
        if(!$user->employee()->get()->isEmpty()) {
            $user = $user->employee->first()->manager;
        }

        if($user->plan()->get()->isEmpty()){
            return redirect()->route('payPremium');
        }

        $user = \Auth::user();
        if($user->hasRole("employee")) {
            $user = $user->employee->first()->manager;
        }
        $checkouts = $user->currentCheckoutRequests()->orderBy("status")->paginate(20);
        return view("shop.checkouts", [
            "checkouts" => $checkouts,
            "status" => [
                0 => ["Package", "shop"],
                1 => ["Ship", "shop"],
                2 => ["Delivered", "customer"],
                3 => ["Recieve payment", "shop"],
                4 => ["Payment Received", "none"],
            ]
        ]);
    }

    public function updateCheckoutStatus(CurrentCheckout $checkout) {
        $user = \Auth::user();
        if(!$user->employee()->get()->isEmpty()) {
            $user = $user->employee->first()->manager;
        }

        if($user->plan()->get()->isEmpty()){
            return redirect()->route('payPremium');
        }

        $user = \Auth::user();
        if($user->hasRole("employee")) {
            $user = $user->employee->first()->manager;
        }
        if($checkout->shop->id == $user->id) {
            if($checkout->status < 4) {

                $checkout->status++;
                if($checkout->status == 4) {
                    $cartHistory = new CartHistory;
                    $cartHistory->price = $checkout->price;
                    $cartHistory->quantity += $checkout->quantity;
                    $cartHistory->user()->associate($checkout->user);
                    $cartHistory->shop()->associate($user);
                    $cartHistory->product()->associate($checkout->product);
                    $cartHistory->save();
                    $checkout->delete();
                }
                else {
                    $checkout->save();
                }

            }
        }
        return back();
    }

    public function previousOrders() {
        $user = \Auth::user();
        if(!$user->employee()->get()->isEmpty()) {
            $user = $user->employee->first()->manager;
        }

        if($user->plan()->get()->isEmpty()){
            return redirect()->route('payPremium');
        }


        $orders = CartHistory::seller()->latest()->paginate(20);

        return view("shop.previous_orders", [
            "orders" => $orders,
        ]);
    }

    public function orderDetails(CartHistory $order) {
        $user = \Auth::user();
        if(!$user->employee()->get()->isEmpty()) {
            $user = $user->employee->first()->manager;
        }

        if($user->plan()->get()->isEmpty()){
            return redirect()->route('payPremium');
        }


        return view("shop.order_details", [
            "order" => $order
        ]);
    }

    public function deleteProductImage(Request $request, ProductImage $image) {
        $user = \Auth::user();
        if(!$user->employee()->get()->isEmpty()) {
            $user = $user->employee->first()->manager;
        }

        if($user->plan()->get()->isEmpty()){
            return redirect()->route('payPremium');
        }


        if(\Auth::user()->id == $image->product->user->id) {
            \Storage::delete();
            $image->delete();
        }
        return back();
    }

}

