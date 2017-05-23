<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Role;
use App\UserDetail;
use App\RegistrationRequest;
use Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }


    /**
     * Overriding registration form to pass extra fields
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function showRegistrationForm()
    {
        return view('auth.register', [
            "prefix" => Request::route()->getPrefix(),
        ]);
    }

    /**
     * Overriding registration method
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */

    public function register(Request $request)
    {
        $this->validator(Request::all())->validate();

        event(new Registered($user = $this->create(Request::all())));

        $this->guard()->login($user);



        $role = null;
        $userDetail = new UserDetail;

        if(Request::route()->getPrefix() == "/vendor") {
            $role = \App\Role::all()->where("name", "=", "vendor")->first();
            $userDetail->status = "suspended";
            
            $registrationRequest = new RegistrationRequest;
            $registrationRequest->user()->associate($user);
            $registrationRequest->save();
        }
        else if(Request::route()->getPrefix() == "/admin") {

        }
        else if(Request::route()->getPrefix() == "/customer") {
            $role = \App\Role::all()->where("name", "=", "customer")->first();
            $userDetail->status = "active";

        }
        $user->roles()->attach($role);
        $user->save();

        $userDetail->gender = Request::input("gender");
        $userDetail->date_of_birth = Request::input("date_of_birth");
        $userDetail->user()->associate($user);
        try {
            $userDetail->save();

        }
        catch(Exception $e) {
            echo $e->getMessage();
        }

        return redirect()->view('auth/register');
    }
}
