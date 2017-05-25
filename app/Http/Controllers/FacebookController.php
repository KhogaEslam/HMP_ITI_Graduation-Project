<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Mockery\Exception;
use Laravel\Socialite\Facades\Socialite;

use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
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
        }
        else{
            if (isset($user->user['birthday'])){
                $date_of_birth = Carbon::parse($user->user['birthday'])->format('m-d-Y');
            }
            else{
                $date_of_birth="";
            }

            if ($user->email){
                $email=$user->email;
            }
            else{
                $email="";
            }

            if ($user->user['gender']){
                $gender=$user->user['gender'];
            }
            else{
                $gender="";
            }

            return view("facebook", [
                "prefix" =>"/customer",
                "email" => $email,
                "name" => $user->name,
                "date_of_birth" => $date_of_birth,
                "gender"=>$gender
            ]);
        }
    }

}