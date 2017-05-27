<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Mail;
class MailController extends Controller
{
    public function mail($user)
    {
        if ($user){
            Mail::send('emails.mailEvent', $user, function($message) use ($user) {
                $message->to($user->emil);
                $message->subject('Mailgun Testing');
            });
            dd('Mail Send Successfully');
        }
    }
}
