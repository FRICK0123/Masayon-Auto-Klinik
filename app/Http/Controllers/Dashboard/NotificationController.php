<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    //Customer Notification Overview
    public function customerNotificationView(){
        $notifications = Notification::where('customerID',Auth::guard('customer')->id())->get();
        return view('pages.customer_pages.notifications',['notifications'=>$notifications]);  
    }
}
