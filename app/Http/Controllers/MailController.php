<?php

namespace App\Http\Controllers;


use App\Mail\EmailConfirmation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use App\Http\Requests;

class MailController extends Controller
{
    public function basic_email()
    {
        $email = 'positronx@gmail.com';

        $maildata = [
            'title' => 'Laravel Mail Sending Example with Markdown',
            'url' => 'http://localhost/main'
        ];

        Mail::to($email)->send(new EmailConfirmation($maildata));

        dd("Mail has been sent successfully");


    }
}
