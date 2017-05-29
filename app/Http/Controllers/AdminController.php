<?php

namespace App\Http\Controllers;

use App\Category;
use App\FeaturedProduct;
use Illuminate\Http\Request;
use App\Http\Requests\OfferRequest;
use App\Offer;
use \Carbon\Carbon;
use App\FeaturedItem;

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

    //=================================  Categories  ===================================== //
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

    //=================================  Subscription Requests  ===================================== //

    /**
     * acceptSubscriptionRequest
     * The function is used to accept vendor subscription requests
     * @author Mohamed Magdy
     * @param Request $request
     * @return  view
     */

    public function acceptSubscriptionRequest( )
    {

    }
    public function rejectSubscriptionRequest()
    {

    }

    public function showAddOfferForm() {
        return view("admin.new_offer");
    }

    public function addOffer(OfferRequest $request) {
        $offers = Offer::all();
        $incomingStartDate = Carbon::parse($request->input("start_date"));
        $incomingEndDate = Carbon::parse($request->input("end_date"));
        foreach($offers as $offer) {
            $existingStartDate = Carbon::parse($offer->start_date);
            $existingEndDate = Carbon::parse($offer->end_date);
            if(! $existingStartDate->greaterThanOrEqualTo($incomingEndDate) && ! $existingEndDate->lessThanOrEqualTo($incomingStartDate)) {
                return view("admin.new_offer")->withErrors([
                    "overlapping" => "This offer overlaps existing offer [" . $existingStartDate . " - " . $existingEndDate . "]"
                ]);
            }

        }
        Offer::create($request->all());
        return redirect(action("AdminController@index"));
    }

    public function viewFeaturedRequests() {
        $featuredRequests = FeaturedItem::all();
        return view("admin.featured_requests", [
            "featuredRequests" => $featuredRequests,
        ]);
    }

    public function acceptFeaturedRequest(FeaturedItem $item) {
        if(FeaturedProduct::find($item->product)->isEmpty()) {
            $featuredProduct = new FeaturedProduct;
            $featuredProduct->product()->associate($item->product);
            $featuredProduct->save();
            $item->delete();
        }
        return back();
    }

    public function rejectFeaturedRequest(FeaturedItem $item) {
        $item->delete();
        return back();
    }

}
