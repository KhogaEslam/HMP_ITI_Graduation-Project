<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Mockery\Exception;
use Socialite;

use App\User;
use Request;
class FacebookController extends Controller
{
    /**
     * Redirect the user to the Facebook authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return  Socialite::driver('facebook')->fields([
            'name', 'email', 'gender', 'birthday'
        ])->scopes([
            'email', 'user_birthday'
        ])->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {

        try{
        $user =Socialite::driver('facebook')->fields([
            'name', 'email', 'gender', 'birthday'
        ])->user();
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

            return view("facebook", [
                "prefix" =>Request::route()->getPrefix(),
                "email" => $user->email,
                "name" => $user->name,
                "date_of_birth" => $user->user['birthday'],
                "gender"=>$user->user['gender']
            ]);
        }
    }

}