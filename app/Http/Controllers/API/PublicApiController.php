<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User,Paymode,Payin,BankAccount,profileImage,Banner,SiteContent,Notification,DeleteNotification};
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PublicApiController extends Controller
{
    //Users
    
    public function UserProfile(Request $request){
        try {
            
            $validator = Validator::make($request->all(), [
                'userId' => 'required|numeric',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['success' => false,'message' => $validator->errors()->first()]);
            }
            
            $user = User::where([['id',$request->userId],['role_id','2']])->first();
            
            if($user){
                return response()->json(['success'=>true,'url' => 'https://root.couponpe.in/assets/profile', 'data'=>$user]);
            }
            return response()->json(['success' => false, 'message' => 'User not found']);
        }catch (Exception $e) {
            return response()->json(['error' => 'API request failed: ' . $e->getMessage()], 500);
        }
    }

 
    
    public function UserProfileUpdate(Request $request) {
    try {
        $validator = Validator::make($request->all(), [
            'userId' => 'required|exists:users,id', 
            'name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'email' => 'nullable|email',
            'profile_image' => 'nullable|string',
            'state' => 'nullable|string',
            'city' => 'nullable|string',
            'address' => 'nullable|string',
            'date_of_birth' => 'nullable|date'
        ]);

        $validator->stopOnFirstFailure();
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }

        $user = User::findOrFail($request->userId);
        $data = [];
        if ($request->filled('name')) {
            $data['name'] = $request->name;
        }
        if ($request->filled('last_name')) {
            $data['last_name'] = $request->last_name;
        }
        if ($request->filled('email')) {
            $data['email'] = $request->email;
        }
        if ($request->filled('state')) {
            $data['state'] = $request->state;
        }
        if ($request->filled('city')) {
            $data['city'] = $request->city;
        }
        if ($request->filled('address')) {
            $data['address'] = $request->address;
        }
        if ($request->filled('date_of_birth')) {
            $data['date_of_birth'] = $request->date_of_birth;
        }
        if ($request->filled('profile_image')) {
            // Decode the base64 image
            $imageData = explode(',', $request->profile_image);
            $image = base64_decode($imageData[0]); // Correct index for base64 string

            // Generate a filename
            $filename = time() . '.jpg'; // You can change the extension based on the format

            // Save the image to a file
            $filePath = public_path('/assets/profile' . $filename);
            file_put_contents($filePath, $image);

            $data['profile_image'] = $filename; // Store the file path relative to the public directory
        }

        if (empty($data)) {
            return response()->json(['success' => false, 'message' => 'No data to update.'], 400);
        }
   
        $check = $user->update($data);
        if ($check) {
            return response()->json(['success' => true, 'message' => 'Updated Successfully..!']);
        }
        return response()->json(['success' => false, 'message' => 'Something went wrong..!']);
    } catch (Exception $e) {
        return response()->json(['error' => 'API request failed: ' . $e->getMessage()], 500);
    }
}



    
    public function ProfileImage(){
        try {
            $profileImage = ProfileImage::where('status',1)->get();
            if($profileImage){
                return response()->json(['success'=>true,'message' =>'Successfully' , 'data'=>$profileImage]);
            }
            return response()->json(['success' => false, 'message' => 'Data not found']);
        }catch (Exception $e) {
            return response()->json(['error' => 'API request failed: ' . $e->getMessage()], 500);
        }
    }
    
    
    
    // Banner
    
    public function Banners(){
        try {
            $banner = Banner::where('status',1)->get();
            if($banner){
                return response()->json(['success'=>true,'message' =>'Successfully' ,'url' => env('APP_URL').'assets/banner/' ,'data'=>$banner]);
            }
            return response()->json(['success' => false, 'message' => 'Data not found']);
        }catch (Exception $e) {
            return response()->json(['error' => 'API request failed: ' . $e->getMessage()], 500);
        }
    }
    
    //SideContents
    
    public function SiteContents($id){
        try {
            $siteContent = SiteContent::whereIn('id', [1, 2, 3])->where('id', $id)->first();
            $support = SiteContent::whereIn('id', [4,5,6,7,8,9,10])->get();

            if($siteContent){
                return response()->json(['success'=>true,'message' =>'Successfully' , 'type' =>'1 = privacy policy 2 = Terms and conditions 3 = About us','data'=>$siteContent, 'support' => $support]);
            }
            return response()->json(['success' => false, 'message' => 'Data not found']);
        }catch (Exception $e) {
            return response()->json(['error' => 'API request failed: ' . $e->getMessage()], 500);
        }
    }
    
    //Notification
    
    public function Notifications(Request $request){
    try {
        $validator = Validator::make($request->all(), [
            'userId' => 'required|numeric|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

        // Retrieve notifications to delete for the user
        $deletedNotifications = DeleteNotification::where('user_id', $request->userId)->pluck('notification_id')->toArray();

        // Retrieve active notifications, excluding deleted ones
        $notifications = Notification::where('status', 1)
            ->whereNotIn('id', $deletedNotifications)
            ->get();

        if ($notifications->isNotEmpty()) {
            return response()->json(['success' => true, 'message' => 'Successfully retrieved notifications', 'data' => $notifications]);
        }

            return response()->json(['success' => false, 'message' => 'Data not found', 'data' =>[]]);
        } catch (Exception $e) {
            return response()->json(['error' => 'API request failed: ' . $e->getMessage()], 500);
        }
    }

    
    public function NotificationDelete(Request $request){
    try {
        $validator = Validator::make($request->all(), [
            'userId' => 'required|numeric|exists:users,id',
            'notificationId' => 'required|numeric|exists:notifications,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

        // Check if the notification is already deleted
        $notificationDelete = DeleteNotification::where('user_id', $request->userId)
            ->where('notification_id', $request->notificationId)
            ->first();

        if ($notificationDelete) {
            return response()->json(['success' => false, 'message' => 'Notification already deleted..!']);
        }

        // Create a new entry in the DeleteNotification table
        $deletedNotification = DeleteNotification::create([
            'user_id' => $request->userId,           // corrected to 'user_id'
            'notification_id' => $request->notificationId, // corrected to 'notification_id'
        ]);

        if ($deletedNotification) {
            return response()->json(['success' => true, 'message' => 'Notification deleted successfully..!']);
        }

        return response()->json(['success' => false, 'message' => 'Failed to delete notification']);
    } catch (Exception $e) {
        return response()->json(['error' => 'API request failed: ' . $e->getMessage()], 500);
    }
}


    public function Referral(Request $request){
    $validator = Validator::make($request->all(), [
        'userId' => 'required|numeric|exists:users,id',
    ]);

    if ($validator->fails()) {
        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
    }
    
    // Retrieve the user by userId while eager loading the sponsor
    $user = User::where('referral_user_id',$request->userId)->get();

    // Check if the user exists
    if (!$user) {
        return response()->json(['success' => false, 'message' => 'User not found.']);
    }

    // Check if the user has a sponsor
    if ($user) {
        $sponsorId = $user; // Get the sponsor ID
    } else {
        $sponsorId = null; // No sponsor found
    }

    return response()->json(['success' => true, 'referral_his' => $sponsorId]);
}


    
    
    
    // Bank account
    public function BankAccount(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'user_id'=> 'required|exists:users,id',  
                'name' => 'required|string|max:32', 
                'bank_name'=> 'required|string|max:32', 
                'Branch'=> 'required|string|max:32', 
                'account_no'=> 'required|string|max:32', 
                'ifsc_code'=> 'required|string|max:16', 
                
            ]);
            $validator->stopOnFirstFailure();
            if ($validator->fails()) {
                $response = ['success' => false,'message' => $validator->errors()->first()];
                return response()->json($response);
            }
            
            $checkbank = BankAccount::where('user_id',$request->user_id)->first();
            
            if($checkbank){
                
                $bankaccount = BankAccount::where('user_id',$request->user_id)->update($validator->validated());

            if($bankaccount){
                return response()->json(['success'=>true,'message' =>'Updated Successfully..!']);
            }
            return response()->json(['success' => false, 'message' => 'Something went wrong..!']);
                
            }
           
           $bankaccount = BankAccount::create($validator->validated());

            if($bankaccount){
                return response()->json(['success'=>true,'message' =>'Created Successfully..!']);
            }
            return response()->json(['success' => false, 'message' => 'Something went wrong..!']);
        }catch (Exception $e) {
            return response()->json(['error' => 'API request failed: ' . $e->getMessage()], 500);
        }
    }

    public function BankAccountView(Request $request){
        try {
            
            $validator = Validator::make($request->all(), [
                'userId' => 'required|numeric|exists:users,id',
            ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }
            
            $bankaccount = BankAccount::where('user_id',$request->userId)->first();
            if($bankaccount){
                return response()->json(['success'=>true,'message' =>'Successfully' , 'data'=>$bankaccount]);
            }
            return response()->json(['success' => false, 'message' => 'Data not found']);
        }catch (Exception $e) {
            return response()->json(['error' => 'API request failed: ' . $e->getMessage()], 500);
        }
    }
    
    public function PayMode(){
        try {
            $paymode = Paymode::where('success',1)->get();
            if($paymode){
                return response()->json(['success'=>true,'message' =>'Successfully' , 'data'=>$paymode]);
            }
            return response()->json(['success' => false, 'message' => 'Data not found']);
        }catch (Exception $e) {
            return response()->json(['error' => 'API request failed: ' . $e->getMessage()], 500);
        }
    }
    
    
    // payin transaction
    
    public function PayinHistory(Request $request){
        try {
            
            $validator = Validator::make($request->all(), [
                'userId' => 'required|numeric|exists:users,id',
            ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }
            
            $payin = Payin::where('user_id',$request->userId)->latest()->get();
            if($payin){
                return response()->json(['success'=>true,'message' =>'Successfully' , 'data'=>$payin]);
            }
            return response()->json(['success' => false, 'message' => 'Data not found']);
        }catch (Exception $e) {
            return response()->json(['error' => 'API request failed: ' . $e->getMessage()], 500);
        }
    }
    
}