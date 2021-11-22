<?php

namespace App\Http\Controllers;

use App\Consultant;
use App\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    //    
    public function sendUser(Request $request, $id) {
        $consultant = Consultant::findOrFail($id);
        $token = $consultant->device_token;
        if($token) {
            return $this->sendNotification(array($token), array(
                'title' => $request->title,
                'body' => $request->message
            ));
        } else {
            return response()->json([
                'code' => 200,
                'message' => 'Ok'
            ], 200);
        }
    }

    public function sendConsultant(Request $request, $id) {
        $user = User::findOrFail($id);
        $token = $user->device_token;
        if($token) {
            return $this->sendNotification(array($token), array(
                'title' => $request->title,
                'body' => $request->message
            ));
        } else {
            return response()->json([
                'code' => 200,
                'message' => 'Ok'
            ], 200);
        }
    }

    public function sendNotification($device_token, $message)
    {    
        $SERVER_API_KEY = env('FIREBASE_KEY');

        $data = [
            "registration_ids" => $device_token,
            "notification" => $message
        ];

        $data = json_encode($data);
    
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($ch);

        curl_close($ch);
        
        return $response;
    }
}
