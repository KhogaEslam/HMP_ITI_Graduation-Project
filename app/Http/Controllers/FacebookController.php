<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Mockery\Exception;
use Socialite;

use App\User;
class FacebookController extends Controller
{
    /**
     * Redirect the user to the Facebook authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {

        try{
        $user = Socialite::driver('facebook')->user();
        }catch (Exception $ex){
            return redirect('facebook.login');
        }
        $authUser=User::where('email','=',$user->email)->first();
        if ($authUser){
            Auth::login($authUser,true);
            return redirect()->route('home');
            // $user->token;
        }
        else{
            return redirect()->action("Auth\RegisterController@showRegistrationForm");
        }
    }
}