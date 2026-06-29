<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SendGridService;

use App\Models\CheckedService;
use App\Models\Customer;
use App\Models\Order;
use App\Models\KiBooking;
use App\Models\Clinic;

class EmailApiTestController extends Controller
{
    protected $sendGrid;

    public function __construct(SendGridService $sendGrid)
    {
        $this->sendGrid = $sendGrid;
    }

    /**
     * Show form page
     */
    public function index()
    {
        return view('emailapitest');
    }

    /**
     * Send simple message from form
     */
    public function send(Request $request)
    {
        $request->validate([
            'to' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $result = $this->sendGrid->sendSimpleMail(
            $request->to,
            $request->subject,
            $request->message
        );

        if ($result['success']) {
            return back()->with('success', $result['message']);
        }

        return back()->with('error', $result['message'] . ': ' . ($result['details'] ?? ''));
    }

    /**
     * Send OTP Mail using HTML Blade
     */
    public function sendOtpMail(Request $request)
    {
        $email = $request->to;
        $otp = rand(100000, 999999);

        $clientData = [
            'name'        => 'User',
            'otp'         => $otp,
            'mobile'      => 'kundan',
            'status'      => 'kundan',
            'update_date' => now()->format("d M Y, H:i:s"),
            'action_by'   => 'kundan',
        ];

        $result = $this->sendGrid->sendOtpMail($email, $clientData);

        return response()->json($result, $result['success'] ? 200 : ($result['status'] ?? 500));
    }
    
    /**
     * Send Order Mail using HTML Blade
     */
    public function sendOrderMail(Request $request)
    {
        $email = $request->to;
        $otp = rand(100000, 999999);
        
        $customer = Customer::where("email", 'nicole8austin@gmail.com')->orderByDesc('id')->first();
        $saveOrder = Order::where("id", '76')->orderByDesc('id')->first();

            $clientData = [
                'name'                => $saveOrder->billing_first_name.' '.$saveOrder->billing_last_name,
                'order_id'            => $saveOrder->id,
                'order_date'          => date('d M Y, H:i:s', strtotime($saveOrder->created_at)),
                'payment_method'      => 'Klarna',
                'payment_status'      => 'Paid',
                'est_delivery_date'   => '22 Oct 2025',
                'order_status'        => 'Processing',
                'status'              => 'Active',
                'update_date'         => now()->format("d M Y, H:i:s"),
                'action_by'           => 'Admin',
            
                // Item details
                'cart_details'        => $saveOrder->cart_details,
                'order_total'        => $saveOrder->order_amount,
                
                // Billing details
                'billing_first_name'  => $saveOrder->billing_first_name,
                'billing_last_name'   => $saveOrder->billing_last_name,
                'billing_company'     => $saveOrder->billing_company,
                'billing_country'     => $saveOrder->billing_country,
                'billing_phone'       => $saveOrder->billing_phone,
                'billing_email'       => $saveOrder->billing_email,
                'billing_address_1'   => $saveOrder->billing_address_1,
                'billing_city'        => $saveOrder->billing_city,
                'billing_postcode'    => $saveOrder->billing_postcode,
            ];


        $result = $this->sendGrid->sendOrderMail($email, $clientData);

        return response()->json($result, $result['success'] ? 200 : ($result['status'] ?? 500));
    }
    
    /**
     * Send Booking Mail using HTML Blade
     */
    public function sendBookingMail(Request $request)
    {
        $email = $request->to;
        $otp = rand(100000, 999999);
        
        $customer = Customer::where("email", 'nicole8austin@gmail.com')->orderByDesc('id')->first();
        $saveKiBooking = KiBooking::where("id", '217')->orderByDesc('id')->first();
        if($saveKiBooking->clinic_id != ''){
            $getClinic = Clinic::where("id", $saveKiBooking->clinic_id)->orderByDesc('id')->first(); 
            $clinic_name = $getClinic->clinic_name ? $getClinic->clinic_name : '';
            $clinic_address = $getClinic->address ? $getClinic->address : '';
        }else{
            $clinic_name = '';
            $clinic_address = '';
        }
        
        $service_name = '';
        foreach (@$saveKiBooking->getKiBookinService() as $items){
            $service_name .= $items->property_name.', ';
        }

            $clientData = [
                'name'                => $saveKiBooking->first_name.' '.$saveKiBooking->last_name,
                'booking_id'            => $saveKiBooking->id,
                'booking_date'          => date('d M Y, H:i:s', strtotime($saveKiBooking->created_at)),
                'payment_method'      => $saveKiBooking->payment_method,
                'payment_status'      => 'Paid',
                'est_delivery_date'   => '22 Oct 2025',
                'order_status'        => 'Processing',
                'status'              => 'Active',
                'update_date'         => now()->format("d M Y, H:i:s"),
                'action_by'           => 'Admin',
            
                // Item details
                'service_name'        => $service_name,
                'cart_details'        => $saveKiBooking->cart_details,
                'payment_amount'        => $saveKiBooking->payment_amount,
                
                // Billing details
                'total_service_duration'  => $saveKiBooking->total_service_duration,
                'slot_date'  => $saveKiBooking->slot_date ? $saveKiBooking->slot_date : $saveKiBooking->selected_date,
                'slot_time'  => $saveKiBooking->slot_time ? $saveKiBooking->slot_time : $saveKiBooking->selected_time,
                
                'clinic_name'  => $clinic_name,
                'clinic_address'  => $clinic_address,
                
            ];


        $result = $this->sendGrid->sendBookingMail($email, $clientData);

        return response()->json($result, $result['success'] ? 200 : ($result['status'] ?? 500));
    }
    
    /**
     * Send Welcome Mail using HTML Blade
     */
    public function sendWelcomeMail(Request $request)
    {
        $email = $request->to;

        $customer = Customer::where("email", 'nicole8austin@gmail.com')->orderByDesc('id')->first();
        
            $clientData = [
                'name'                => $customer->billing_first_name,
                
            ];


        $result = $this->sendGrid->sendWelcomeMail($email, $clientData);

        return response()->json($result, $result['success'] ? 200 : ($result['status'] ?? 500));
    }
    
        
    /**
     * Send Birthday Mail using HTML Blade
     */
    public function sendBirthdayMail2(Request $request)
    {
        $email = $request->to;

        $customers = Customer::where("dob", date())->orderByDesc('id')->get();
        foreach($customers as $customer){
            $clientData = [
                'name'                => $customer->first_name,
                
            ];


            $result = $this->sendGrid->sendBirthdayMail($email, $clientData);
        }

        return response()->json($result, $result['success'] ? 200 : ($result['status'] ?? 500));
    }
    
    public function sendBirthdayMail(Request $request)
    {
        /*$email = "akundan55@gmail.com";
        $customer = Customer::where("email", $email)->orderByDesc('id')->first();
        $clientData = [
                'name' => $customer->first_name,
            ];
        $result = $this->sendGrid->sendBirthdayMail($email, $clientData);*/
        
        // Today date in Y-m-d format
        $today = date('m-d'); // birthday comparison only needs month-day
    
        // Get all customers whose birthday is today
        $customers = Customer::whereRaw("DATE_FORMAT(dob, '%m-%d') = ?", [$today])
                            ->orderByDesc('id')
                            ->get();
    
        if ($customers->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No customers have birthday today.'
            ], 404);
        }
    
        foreach ($customers as $customer) {
    
            // customer ka apna email bhejna chahiye
            $email = $customer->email;
    
            $clientData = [
                'name' => $customer->first_name,
            ];
    
            $result = $this->sendGrid->sendBirthdayMail($email, $clientData);
        }
    
        return response()->json([
            'success' => true,
            'message' => 'Birthday mails sent successfully!'
        ], 200);
    }
    
    
    
}
