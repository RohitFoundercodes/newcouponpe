<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User,Payin,Paymode,BankAccount,profileImage,Banner,SiteContent,Notification,DeleteNotification};
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class PaymentController extends Controller
{
    
    public function payin(Request $request){
        try{
        // Validate incoming request
        $this->validatePayinRequest($request);
         $cash = $request->amount;
        $userId = $request->user_id;
        $transactionId=$request->transaction_id;
        $companyOrderId=$request->companyOrderId;
        $iv=$request->iv;
        $orderId = $this->generateOrderId();

        // Fetch user details
        $user = User::find($userId);
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found']);
        }

        // Prepare payment insert
        $redirectUrl = "https://root.couponpe.in/api/checkPayment?order_id=$orderId&transaction_id=$transactionId&companyOrderId=$companyOrderId&iv=$iv&userid=$userId";
        
        // Prepare payment parameters
        $postParameter = $this->preparePaymentParameters($user, $cash, $orderId, $redirectUrl);
        
        $paymentResponse = $this->makePayment($postParameter);
       
        $this->insertPayinRecord($userId, $cash, $orderId, $postParameter);
        
         return response()->json($paymentResponse);
         return response()->json(['success'=>true,'massege' => 'successfully', 'data'=>$paymentResponse]);
         }catch (Exception $e) {
            return response()->json(['error' => 'API request failed: ' . $e->getMessage()], 500);
        }
    }

    private function validatePayinRequest(Request $request)
    {
        
     
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric',
            'type' => 'nullable|in:1',
        ]);
        $validator->stopOnFirstFailure();

         if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }
    }

    private function generateOrderId()
    {
        return now()->format('YmdHis') . rand(11111, 99999);
    }

    private function insertPayinRecord($userId, $cash, $orderId, $postParameter)
    {
        Payin::create([
            'user_id' => $userId,
            'amount' => $cash,
            'paymode_id' => 1,
            'transaction_id' => $orderId,
            'send_response' => json_encode($postParameter),
            'payment_status' => 1,
            'status' => 1,
      
        ]);
        
     
    }

    private function preparePaymentParameters($user, $cash, $orderId, $redirectUrl)
    {
        
        return [
            'merchantid' => "04",
            'orderid' => $orderId,
            'amount' => $cash,
            'name' => $user->name,
            'email' => "abc@gmail.com",
            'mobile' => $user->mobile,
            'type' => 2,
            'remark' => 'payIn',
            'redirect_url' => $redirectUrl,
        ];
    }

    private function makePayment(array $postParameter)
    {
     $response = Http::withHeaders([
        'Content-Type' => 'application/json',
        'Cookie' => 'ci_session=1ef91dbbd8079592f9061d5df3107fd55bd7fb83',
    ])->post('https://indianpay.co.in/admin/paynow', $postParameter);
   
    return $response->json();
    }

    public function checkPayment(Request $request)
    {
        $orderId = $request->input('order_id');
        $transactionId=$request->input('transaction_id');
        $companyOrderId=$request->input('companyOrderId');
        $iv=$request->input('iv');
        $userId=$request->input('userid');

        $paymentUpdated = DB::table('payins')
            ->where('transaction_id', $orderId)
            ->where('status', 1)
            ->update(['status' => 2]);

        if ($paymentUpdated) {
            
             $url = 'https://root.couponpe.in/api/company_order/place-order';
         $data = [
            'user_id' => $userId,
            'iv' => $iv,
            'transactionId' =>$transactionId,
            'companyOrderId' => $companyOrderId
        ];
         $ch = curl_init();
         curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
         $response = curl_exec($ch);
         if (curl_errno($ch)) {
            echo 'cURL Error: ' . curl_error($ch);
        }
         curl_close($ch);
         
            $data1 = DB::table('payins')->where('transaction_id', $orderId)->first();
            
        }
       
         return redirect()->route('payin.successfully');
    }

    private function handlePaymentSuccess($data)
    {
        $userId = $data->user_id;
        $amount = $data->cash;
    }

    private function jsonResponse($status, $message)
    {
        return response()->json(['status' => $status, 'message' => $message]);
    }

    public function redirect_success()
    {
        return view('success');
    }

}