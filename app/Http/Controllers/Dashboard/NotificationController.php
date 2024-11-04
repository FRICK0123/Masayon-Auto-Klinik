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
        $customerID = Auth::guard('customer')->id();
        $notifications = Notification::where('customerID', $customerID)->get();

        // Count notifications with isConfirmed = false
        $unconfirmedCount = Notification::where('customerID', $customerID)
            ->where('isConfirmed', false)
            ->count();

        return view('pages.customer_pages.notifications', [
            'notifications' => $notifications,
            'unconfirmedCount' => $unconfirmedCount
        ]);
    }

    public function confirmNotif($notificationID){
        Notification::where('notificationID',$notificationID)->update(['isConfirmed' => true]);
        return to_route('customer_notification_view');
    }

    public function unconfirmNotif($notificationID)
    {
        Notification::where('notificationID', $notificationID)->update(['isConfirmed'=>false]);
        return to_route('customer_notification_view');
    }
}
