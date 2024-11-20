<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function sendMail(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        $data = [
            'fullname' => $request->fullname,
            'email' => $request->email,
            'message_content' => $request->message, // Use a unique key name
        ];

        Mail::send('emails.contact', $data, function ($message) use ($request) {
            $message->to('paculbafrick1@gmail.com')
                ->subject('New Contact Message')
                ->from($request->email, $request->fullname);
        });

        session()->flash('contact',"Your Message has been sent successfully");

        return to_route('homepage');
    }

}
