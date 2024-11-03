<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Notification;
use Illuminate\Http\Request;
use GuzzleHttp\Client as GuzzleHttpClient;

class AdminNotificationController extends Controller
{
    //Store Notification Data and Send Notification
    public function notifyCustomer(Request $request){
        $customerID = $request->input('customerID');
        $vehicleID = $request->input('vehicleID');
        $maintenanceID = $request->input('maintenanceID');
        $owner = $request->input('owner');
        $vehicle = $request->input('vehicle');
        $maintenance_type = $request->input('maintenance_type');
        $scheduled_date = $request->input('scheduled_date');
        $content = "Good Day Sir/Ma'am ". $owner. ", we would like to inform you that your ". $vehicle. " is due for ". $maintenance_type. " on ". $scheduled_date. ". PLease arrive within the scheduled date to keep your vehicle on top condition";

        $customer = Customer::where('customerID',$customerID)->first();
        $customerNum = "+63".$customer['phone_number'];

        $client = new GuzzleHttpClient();
        $apiKey = "6txNEfdDAqAZSHw1PF18iWG0GkWHtGeBW_sAX9z8PEUS59HU3zuZAgd_h8wiLuv6";

        $res = $client->request('POST', 'https://api.httpsms.com/v1/messages/send', [
            'headers' => [
                'x-api-key' => $apiKey,
            ],
            'json'    => [
                'content' => "From Masayon Auto Klinik: \nGood Day Sir/Ma'am " . $owner . ", we would like to inform you that your " . $vehicle . " is due for " . $maintenance_type . " on " . $scheduled_date . ". PLease arrive within the scheduled date to keep your vehicle on top condition",
                'from'    => "+639999129152",
                'to'      => $customerNum
            ]
        ]);

        Notification::create([
            'customerID' => $customerID,
            'vehicleID' => $vehicleID,
            'maintenanceID' => $maintenanceID,
            'owner' => $owner,
            'vehicle' => $vehicle,
            'maintenance_type' => $maintenance_type,
            'content' => $content,
            'isConfirmed' => false,
        ]);

        return to_route('maintenance_overview');
    }

    //Notification View
    public function notificationView(){
        return view('pages.admin_pages.admin_notification',[
            'notifications' => Notification::orderBy('created_at','desc')->get(),
        ]);
    }

}
