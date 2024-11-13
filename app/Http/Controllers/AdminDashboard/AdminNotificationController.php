<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\MaintenanceSchedule;
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
        $scheduled_date_orig = $request->input('scheduled_date_orig');
        $content = "Good Day Sir/Ma'am ". $owner. ", we would like to inform you that your ". $vehicle. " is due for ". $maintenance_type. " on ". $scheduled_date. ". PLease arrive within the scheduled date to keep your vehicle on top condition";

        $customer = Customer::where('customerID',$customerID)->first();
        $customerNum = "+63".$customer['phone_number'];

        //Send SMS notification
            $client = new GuzzleHttpClient();
            $apiKey = "6txNEfdDAqAZSHw1PF18iWG0GkWHtGeBW_sAX9z8PEUS59HU3zuZAgd_h8wiLuv6";

            $res = $client->request('POST', 'https://api.httpsms.com/v1/messages/send', [
                'headers' => [
                    'x-api-key' => $apiKey,
                ],
                'json'    => [
                    'content' => "From Masayon Auto Klinik: \nGood Day Sir/Ma'am " . $owner . ", we would like to inform you that your " . $vehicle . " is due for " . $maintenance_type . " on " . $scheduled_date . ". Please arrive within the scheduled date to keep your vehicle on top condition",
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
                'scheduled_date' => $scheduled_date_orig,
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

    //Send Regards Notification
    //Store Notification Data and Send Notification
    public function sendRegards(Request $request)
    {
        $customerID = $request->input('customerID');
        $vehicleID = $request->input('vehicleID');
        $maintenanceID = $request->input('maintenanceID');
        $owner = $request->input('owner');
        $vehicle = $request->input('vehicle');
        $maintenance_type = $request->input('maintenance_type');
        $scheduled_date = $request->input('scheduled_date');
        $scheduled_date_orig = $request->input('scheduled_date_orig');
        $last_maintenance_date = $request->input('last_maintenance_date');
        $content = "Hi $owner, we hope your $vehicle is running smoothly after the recent $maintenance_type on $last_maintenance_date. If you have any questions or need further assistance, please reach out. Safe travels! - MASAYON AUTO KLINIK";

        $customer = Customer::where('customerID', $customerID)->first();
        $customerNum = "+63" . $customer['phone_number'];

        //Send SMS notification
        $client = new GuzzleHttpClient();
        $apiKey = "6txNEfdDAqAZSHw1PF18iWG0GkWHtGeBW_sAX9z8PEUS59HU3zuZAgd_h8wiLuv6";

        $res = $client->request('POST', 'https://api.httpsms.com/v1/messages/send', [
            'headers' => [
                'x-api-key' => $apiKey,
            ],
            'json'    => [
                'content' => "Hi $owner, we hope your $vehicle is running smoothly after the recent $maintenance_type on $last_maintenance_date. If you have any questions or need further assistance, please reach out. Safe travels! - MASAYON AUTO KLINIK",
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
            'scheduled_date' => $scheduled_date_orig,
            'content' => $content,
            'isConfirmed' => false,
        ]);

        MaintenanceSchedule::where('maintenanceID',$maintenanceID)->update([
            'isRegarded' => true,
        ]);

        return to_route('maintenance_overview');
    }
}
