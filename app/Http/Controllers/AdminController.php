<?php

namespace App\Http\Controllers;

use App\Category;
use App\RegistrationRequest;
use App\UserDetail;
use Illuminate\Http\Request;
use App\Http\Requests\OfferRequest;
use App\Offer;
use \Carbon\Carbon;

class AdminController extends Controller
{
    //================================= Constructor ==================================== //
    public function __construct()
    {
//        $this->middleware(["admin.auth"]);
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
        return view( 'admin.new-category');
    }

    /**
     * createCategory
     * The function is used to receive the requests from new category view and save the data in the database
     * @author Mohamed Magdy
     * @param  Request $request
     * @return  \Illuminate\Http\RedirectResponse
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
     * @author Mohamed Magdy
     * @param Category $cat
     * @return  \Illuminate\Http\RedirectResponse
     */
    public function editCategory(Category $cat)
    {
        return view ('admin.edit-category',compact('cat') );
    }

    /**
     * updateCategory
     * The function is used to receive the requests from edit category view and update this category in the database
     * @author Mohamed Magdy
     * @param Request $request
     * @param Category $category
     * @return  \Illuminate\Http\RedirectResponse
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
     * @author Mohamed Magdy
     * @param  Request $request
     * @param Category $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteCategory(Request $request ,  Category $category )
    {
        $category->delete();
        return back();
    }

    //=================================  Registeration Requests  ===================================== //

    /**
     * viewALlRegRequests
     * The function is used to view all vendor registeration requests
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
     * The function is used to accept specific vendor registeration request
     * @author Mohamed Magdy
     * @param Request $request
     * @param
     * @return  \Illuminate\Http\RedirectResponse
     */
    public function acceptRegRequest(Request $request, RegistrationRequest $regReq)
    {
//        $userDetails  = UserDetail::all();
//        dd($userDetails);
        $regReq->user->userDetails->status='0';
        $regReq->user->userDetails->save();
        $regReq->delete();
        return back();
    }

    /**
     * rejectRegRequest
     * The function is used to reject specific vendor registeration request
     * @author Mohamed Magdy
     * @param Request $request
     * @param RegistrationRequest $regReq
     * @return \Illuminate\Http\RedirectResponse
     */
    public function rejectRegRequest(Request $request, RegistrationRequest $regReq)
    {
        $regReq->user->delete();
        $regReq->delete();
        return back();
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


}
