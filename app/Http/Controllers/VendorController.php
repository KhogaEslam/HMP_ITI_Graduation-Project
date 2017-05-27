<?php

namespace App\Http\Controllers;

use App\ProductImage;
use App\User;
use App\UserDetail;
use Illuminate\Http\Request;
use App\Category;
use App\Product;
use Validator;
use App\Employee;
use \App\Role;
use \App\Http\Requests\EmployeeRequest;
use \App\Http\Requests\EditEmployeeRequest;

class VendorController extends Controller
{

    public function __construct()
    {
        $this->middleware(["vendor.auth"])->only("showAddEmployeeForm", "addEmployee", "showEditEmployeeForm", "editEmployee", "deleteEmployee");
        $this->middleware(["employee.auth"]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        if (\Auth::check() && \Auth::user()->hasRole("vendor")) {
            $categories = Category::all();
            return view("shop.index", [
                "categories" => $categories
            ]);
        }
    }

    /**
     * Listing all the products inside certain category that belongs to the current vendor
     * @param Category $category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function category(Category $category)
    {
        if (\Auth::check() && \Auth::user()->hasRole("vendor")) {
            $products = $category->products()->owned()->get();
            return view("shop.products", [
                "products" => $products,
                "category" => $category,
            ]);
        }
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
        $upload_to = resource_path("img");
        $product = new Product($request->all());
        $product->user()->associate(\Auth::user());
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
        return view("shop.product", [
            "product" => $product,
            "category" => $category,
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
            $product->update($request->all());
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
}
