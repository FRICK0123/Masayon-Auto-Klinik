<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Mail\ReplyToCustomer;
use App\Models\Inbox;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class InboxController extends Controller
{
    //Inbox View
    public function inboxView(){
        $inboxes = Inbox::orderBy('created_at','desc')->get();
        return view('pages.admin_pages.admin_inbox',[
            'inboxes' => $inboxes,
        ]);
    }

    public function sendInboxReply(Request $request){

        $request->validate([
            'fullname' => 'required|string',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        $fullname = $request->input('fullname');
        $email = $request->input('email');
        $replyMessage = $request->input('message');
        $inboxID = $request->input('inboxID');

        // Send the email
        Mail::to($email)->send(new ReplyToCustomer($replyMessage, $fullname));

        Inbox::where('inboxID',$inboxID)->first()->delete();
        session()->flash('sent',"Reply Sent Successfully");

        return to_route('inbox_view');
    }
}
