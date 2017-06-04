<?php

namespace App\Http\Controllers;

use App\CategoryRequest;
use App\Http\Requests\BannerRequest;
use App\ProductImage;
use App\User;
use App\UserDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Category;
use App\Product;
use App\Discount;
use App\FeaturedItem;
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
        return view( 'shop.new-category');
    }

    /**
     * createCategory
     * The function is used to receive the requests from new category view and save the data in the database
     * @author Mohamed Magdy
     * @param  Request $request
     * @return  \Illuminate\Http\RedirectResponse
     */
    public function requestCategory(Request $request)
    {
        $this->validate($request, ['name' => 'required']);
        $catRequest = new CategoryRequest();
        $catRequest->name = $request->name;
        $catRequest->user()->associate(\Auth::user());
        $catRequest->save();
        return redirect('/shop');
    }

    /**
     * Listing all the products inside certain category that belongs to the current shop
     * @param Category $category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function category(Category $category)
    {
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
        return view("shop.edit_product", compact("category", "product"));
    }

    public function editProduct(Request $request, Category $category, Product $product)
    {
        if($product->user->id == \Auth::user()->id) {
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
        if($product->user->id == \Auth::user()->id) {
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
        if($product->user->id == \Auth::user()->id) {
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
        if($product->user->id == \Auth::user()->id) {
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
        return view("shop.new_employee");
    }

    public function newEmployee(EmployeeRequest $request) {

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
        return view("shop.edit_employee", ["employee" => $employee]);
    }

    public function editEmployee(EditEmployeeRequest $request, Employee $employee) {
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
        if(\Auth::user()->id == $employee->manager->id) {
            $employee->self->delete();
        }
    }

    public function showEmployees() {
        $employees = Employee::all()->where("manager_id", "=", \Auth::user()->id);
        return view("shop.employees", [
            "employees" => $employees
        ]);
    }


    public function showDiscountProductForm(Product $product)
    {
        return view("shop.add_discount",[
            'product' => $product
        ]);
    }

    public function newDiscount(Request $request, Product $product)
    {
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
            $discount->delete();
            return back();
    }

    public function makeFeaturedItemRequest($product)
    {
        $featuredItem = new FeaturedItem();
        $featuredItem->product_id = $product->id;
        $featuredItem->user_id = \Auth::user()->id;
        $featuredItem->save();
        return back();
    }

    public function showBannerRequestForm() {
        $products = Product::owned()->get()->pluck("name", "id");
        return view("shop.banner_request", compact("products"));
    }

    public function addBannerRequest(BannerRequest $request) {
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
            $banner->connected_id = \Auth::user()->id;
        }
        $banner->save();
        return redirect(action("VendorController@index"));
    }

    public function mostSoldProducts() {
        $products = Product::owned()->topSale()->paginate(20);
        return view("shop.top_sale", [
            "products" => $products,
        ]);
    }

    public function mostProfitableProducts() {
        $products = Product::owned()->topProfit()->paginate(20);
        return view("shop.top_profit", [
            "products" => $products
        ]);
    }

    public function mostProfitableCategories() {
        $products = Product::owned()
            ->select("category_id", DB::raw("sum(revenue) as total_revenue"))
            ->groupBy("category_id")
            ->orderBy("total_revenue", "desc")
            ->paginate(20);

        return view("shop.top_categories", [
            "products" => $products
        ]);
    }

    public function showNewAddressesForm() {
        $addresses = \Auth::user()->addresses;
        $counter = $addresses->count();
        if($counter == 0)
            $counter++;
        return view("shop.new_addresses", [
            "addresses" => $addresses,
        ]);
    }

    public function showNewPhonesForm() {
        $phones = \Auth::user()->phones;
        return view("shop.new_phones", [
            "phones" => $phones
        ]);
    }

    public function newAddress(Request $request) {
        $this->validate($request, [
            "addresses" => "required",
            "addresses.*" => "required"
        ]);
        $addresses = $request->input("addresses");
        foreach($addresses as $address) {
            $userAddress = new UserAddress;
            $userAddress->address = $address;
            $userAddress->user()->associate(\Auth::user());
            $userAddress->save();
        }
        return redirect()->action("VendorController@addresses");
    }

    public function deleteAddress(UserAddress $address) {
        if($address->user_id == \Auth::user()->id) {
            $address->delete();
        }
        return back();
    }

    public function addresses() {
        $addresses = \Auth::user()->addresses()->paginate(20);
        return view("shop.addresses", [
            "addresses" => $addresses
        ]);
    }

    public function newPhones(Request $request) {
        $this->validate($request, [
            "new_phones" => "required",
            "new_phones.*" => "required|regex:/(01)[0-9]{9}/",
        ]);
        $phones = $request->input("new_phones");
        foreach($phones as $phone) {
            $userPhone = new UserPhone;
            $userPhone->number = $phone;
            $userPhone->user()->associate(\Auth::user());
            $userPhone->save();
        }
        return redirect()->action("VendorController@phones");
    }

    public function phones() {
        $phones = \Auth::user()->phones()->paginate(20);
        return view("shop.phones", [
            "phones" => $phones
        ]);
    }

    public function deletePhone(UserPhone $phone) {
        if($phone->user_id == \Auth::user()->id) {
            $phone->delete();
        }
        return back();
    }

}

