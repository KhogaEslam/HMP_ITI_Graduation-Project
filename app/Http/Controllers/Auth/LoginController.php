<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Role;
use App\Category;
use App\Helpers\GuestCart;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        $categories = Category::all();
        return view('auth.login', [
            "prefix" => Request::route()->getPrefix(),
            "categories" => $categories,
        ]);
    }

    public function login(Request $request)
    {
        $request = Request::instance();
        $this->validateLogin(Request::instance());


        /**
         * Checking if the user is logging in the correct section
         */

        $prefix = substr(Request::route()->getPrefix(), 1);
//        $role = Role::all()->where("name", "=", $prefix)->first();
//        $user = $role->users()->where("email", "=", $request->input("email"));
//        $exist = $user->get()->count();
        $exist = 0;
        $user = User::all()->where("email", "=", $request->input("email"))->first();
        if(isset($user) && $prefix == "admin" && $user->hasRole("owner"))
            $exist = 1;
        else if(isset($user) && $prefix == "shop" && $user->hasRole("employee"))
            $exist = 1;
        else if(isset($user) && $user->hasRole($prefix))
            $exist = 1;
        if($exist == 0) {
            return $this->sendFailedLoginResponse($request);
        }

        //check suspended account
        if($prefix != 'owner') {
            $status = 0;
            if(! $user->hasRole("owner")) {
                $status = $user->userDetails->status;
            }
            if($status == 1){
                return $this->sendFailedLoginResponse($request);
            }
            //check blocked account
            if($status == 2){
                return $this->sendFailedLoginResponse($request);
            }
        }

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    protected function authenticated($request, $user)
    {
        GuestCart::merge(session("user.cart"), \Auth::user()->cart->cartDetails);
        return redirect($request->route()->getPrefix());
    }
}
