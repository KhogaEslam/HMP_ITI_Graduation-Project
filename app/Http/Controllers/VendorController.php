<?php

namespace App\Http\Controllers;

use App\ProductImage;
use Illuminate\Http\Request;
use App\Category;
use App\Product;
use Validator;

class VendorController extends Controller
{

    public function __construct()
    {
        $this->middleware(["vendor.auth"]);
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

    public function showNewProductForm(Category $category)
    {
        if (\Auth::check() && \Auth::user()->hasRole("vendor")) {
            return view("shop.new_product")->with("category", $category);
        }
    }

    /**
     * @param Request $request
     * @param Category $category
     * @return \Illuminate\Http\RedirectResponse
     */

    public function newProduct(Request $request, Category $category)
    {
        if (\Auth::check() && \Auth::user()->hasRole("vendor")) {
            $upload_to = resource_path("img");
            $product = new Product($request->all());
            $product->user()->associate(\Auth::user());
            $product->category()->associate($category);
            $product->save();
            $files = $request->images;
            $files_count = count($files);
            $uploaded_files = 0;
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
            if ($uploaded_files == $files_count) {
                return redirect()->action("VendorController@category", [$category->id]);
            } else {
                return back()->withInput()->withErrors($validator);
            }
        }
    }

    public function productDetails(Category $category, Product $product)
    {
        if (\Auth::check() && \Auth::user()->hasRole("vendor")) {
            return view("shop.product", [
                "product" => $product,
                "category" => $category,
            ]);
        }
    }

    public function showEditProductForm(Category $category, Product $product)
    {
        if (\Auth::check() && \Auth::user()->hasRole("vendor")) {
            return view("shop.edit_product", compact("category", "product"));
        }
    }

    public function editProduct(Request $request, Category $category, Product $product)
    {
        if (\Auth::check() && \Auth::user()->hasRole("vendor")) {
            $product->update($request->all());
            return redirect()->action("VendorController@productDetails", ["category" => $category, "product" => $product]);
        }
    }

    public function deleteProduct(Category $category, Product $product)
    {
        if (\Auth::check() && \Auth::user()->hasRole("vendor")) {
            \Auth::user()->products()->find($product)->first()->delete();
            return back();
        }
    }

    public function publishProduct(Category $category, Product $product)
    {
        $product = $category->products()->owned()->findOrFail($product)->first();
        $product->published = true;
        $product->save();
        return back();
    }

    public function unPublishProduct(Category $category, Product $product)
    {
        $product = $category->products()->owned()->findOrFail($product)->first();
        $product->published = false;
        $product->save();
        return back();
    }

}
