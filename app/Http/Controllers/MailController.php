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
}
