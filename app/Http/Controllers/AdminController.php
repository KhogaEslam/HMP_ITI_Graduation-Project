<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

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
     * @return: view
     */
    public function index()
    {
        return view('admin.index');
    }

    //================================= Categories ===================================== //
    /**
     * listCategories
     * The function uses Category model to list all categories
     * @author: Mohamed Magdy
     * @return: view
     */
    public function listCategories()
    {
        $cats = Category::all();
        return view('admin.all-categories', ['cats' => $cats]);
    }


    /**
     * newCategory
     * The function is used to render the view of creating new category
     * @author: Mohamed Magdy
     * @return: view
     */

    public function newCategory()
    {
        return view( 'admin.new-category');
    }

    /**
     * createCategory
     * The function is used to receive the requests from new category view and save the data in the database
     * @author: Mohamed Magdy
     * @param : Request object
     * @return: view
     */
    public function createCategory(Request $request)
    {
        $this->validate($request, ['name' => 'required']);
        $cat = new Category();
        $cat->name = $request->name;
        $cat->save();
        return redirect('/admin/categories');

    }

    /**
     * editCategory
     * The function is used to render the view of editing existing category
     * @author: Mohamed Magdy
     * @param: Category object
     * @return: view
     */
    public function editCategory(Category $cat)
    {
        return view ('admin.edit-category',compact('cat') );
    }

    /**
     * updateCategory
     * The function is used to receive the requests from edit category view and update this category in the database
     * @author: Mohamed Magdy
     * @param: Category object -  Request object
     * @return: view
     */
    public function updateCategory(Request $request , Category $cat)
    {
        $this->validate($request, ['name' => 'required']);
        $cat->update($request->all());
        return redirect('/admin/categories');
    }

    /**
     * deleteCategory
     * The function is used to delete specific category from the database records
     * @author: Mohamed Magdy
     * @param: Category object -  Request object
     * @return: view
     */
    public function deleteCategory(Request $request ,  Category $category )
    {
        $category->delete();
        return back();
    }
}
