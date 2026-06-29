<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class PushController extends Controller
{
    public function pushNotification()
    {
        $data = [
            'message' => "Some message",
            'booking_id' => "my booking booking_id",
        ];

        $tokens = [
            'fuOxK7bMISBp4FArdnlFTY:APA91bFMmH8B6rUx9VpuV9mgRUWrIUsSvUam0MIUMg_geJ8r6YeXrfh81RBdw0BcXsyUPZxAmlel3km6fKiY9FLFrnicMARfVimByzHgN-cEBbQUf8XN1_e8CHjtstb7_Zeiaouda3WN'
        ];

        return $this->sendFirebasePush($tokens, $data);
    }

    public function sendFirebasePush($tokens, $data)
    {
        $serverKey = 'AIzaSyCbsGmU8Kgy8HCjP8PgZyghlxNCjfXZJcs';

        $msg = [
            'message' => $data['message'],
            'booking_id' => $data['booking_id'],
        ];

        $notifyData = [
            "body" => $data['message'],
            "title" => "Port App"
        ];

        $fields = [
            'priority' => 'high',
            'notification' => $notifyData,
            'data' => $msg,
        ];

        if (count($tokens) > 1) {
            $fields['registration_ids'] = $tokens; // for multiple users
        } else {
            $fields['to'] = $tokens[0]; // for only one user
        }

        $headers = [
            'Content-Type: application/json',
            'Authorization: key=' . $serverKey,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);

        return $result;
    }
}