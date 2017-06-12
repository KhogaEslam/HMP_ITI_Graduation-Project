<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Mail;
class MailController extends Controller
{
    public function requestRegisterMail()
    {
        $user = User::find(2)->toArray();
        if ($user){
            Mail::send('emails.mailEvent', $user, function($message) use ($user) {
                $message->to($user['email']);
                $message->subject('Verify Account');
                $message->setBody('My <em>amazing</em> body', 'text/html');
            });
            dd('Mail Send Successfully');
        }
    }

    public static function acceptRegistrationMail(User $user)
    {
        $user=$user->toArray();
        Mail::send('emails.mailEvent', $user, function($message) use ($user) {
            $message->to($user['email']);
            $message->subject('Registration Accpetance');
            $message->setBody('Congratulation. We accept your registration. You can login at the following link : <br> '+url('shop/login'), 'text/html');
        });
    }

    public static function rejectRegistrationMail(User $user)
    {
        $user=$user->toArray();
        Mail::send('emails.mailEvent', $user, function($message) use ($user) {
            $message->to($user['email']);
            $message->subject('Registration Reject');
            $message->setBody(' We are sorry to reject your registration request.', 'text/html');
        });
    }


    public static function contactUsMail(Request $request)
    {
        $user=array();
        $user["first_name"] = $request->input('first_name');
        $user["last_name"] = $request->input('last_name');
        $user["email"] = $request->input('email');
        $user["phone "]= $request->input('phone');
        $user["message"] = $request->input('message');

        Mail::send('emails.mailEvent', $user, function($message) use ($user) {
            $message->to($user['email']);
            $message->from("mgmhardwaremarketplace@gmail.com", "Gadgetly");
            $message->setBody("Greetings ! <br>
Thank you for your interest in Gadgetly! <br>
This is to confirm that we have received your email. Our staff will be processing your request and will get back to you if feedback is required.<br>
This email was generated automatically. <br>
Have a nice Day!<br>
Gadgetly Team",
                'text/html');
        });


        Mail::send('emails.mailEvent', $user, function($message) use ($user) {
            $message->to("mgmhardwaremarketplace@gmail.com");
            $message->from($user['email'], $user['first_name']." ".$user['last_name']);
            $message->subject('Contact Us Section');
            $message->setBody($user["message"], 'text/html');
        });

        return back();
    }
}