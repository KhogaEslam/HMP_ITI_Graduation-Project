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
            $message->setBody('Congratulation. We accept your registration. You can login at the following link : <br> http://localhost:8000/shop/login', 'text/html');
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
}
