<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User};
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class AuthApiController extends Controller
{
    
    // public function GetOtp(Request $request) {
    //     $validator = Validator::make($request->all(), [
    //         'mobile' => 'required|numeric|digits:10',
    //         'otp' => 'required|numeric|digits:6|exists:users,otp'
    //     ]);
    
    //     if ($validator->fails()) {
    //         return response()->json(['success' => false,'message' => $validator->errors()->first()], 400);
    //     }
    
    //     $mobile = $request->mobile;
    //     // $name = Str::random(5);
    //     $referralCode = Str::random(6);
    //     $profileImage = mt_rand(1, 10);
        
    //         //testing code    
    //         // $sendResponse = Http::get('https://otp.fctechteam.org/send_otp.php', [
    //         //     'mode' => 'live',
    //         //     'digit' => '4',
    //         //     'mobile' => $mobile
    //         // ]);

    // if ($sendResponse->successful()) {
    // $responseData = $sendResponse->json(); // Get the response as an array
    
    // // Check if the 'error' key exists in the response and validate it
    // if (isset($responseData['error']) && $responseData['error'] == '200') {
    //     $otp = $responseData['otp']; // Access the OTP value from the response
        
    //     $user = User::where('mobile', $mobile)->first();

    //     if ($user) {
    //         $user->update(['otp' => $otp]);
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'OTP send successfully!',
                
    //         ]);
    //     } else {
    //         $newUser = User::create([
    //             // 'name' => $name,
    //             'mobile' => $mobile,
    //             'otp' => $otp
             
    //         ]);
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'OTP send successfully!',
                
    //         ]);
    //     }
    // } else {
    //     return response()->json(['error' => 'Invalid response or OTP failed to send'], 400);
    // }
    //         } else {
    //             return response()->json(['error' => 'Failed to send OTP'], 500);
    //         }

    // }

    public function Login(Request $request) {
    $validator = Validator::make($request->all(), [
        'mobile' => 'required|numeric|digits:10',
    ]);
   
    if ($validator->fails()) {
        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
    }

    // Find user by mobile
    $user = User::where('mobile', $request->mobile)->first();

    // Check if the user exists
    if (!$user) {
        
        User::create(['mobile' => $request->mobile ]);
        
        return response()->json([
            'success' => false,
            'message' => 'You are not registered here..!',
            'status' => 0,
        ]);
    }

    // Check if user has a name and email
    if (is_null($user->name) && is_null($user->email)) {
        return response()->json([
            'success' => false,
            'message' => 'You need to complete your registration.',
            'status' => 0
                  
        ]);
    }

    // Create a token for the authenticated user
    $success['token'] = $user->createToken('UserApp')->plainTextToken;
    $success['userId'] = $user->id;

    return response()->json([
        'success' => true,
        'message' => 'User logged in successfully',
        'status' => 1,
        'data' => $success       
    ]);
}
 public function Loginwithemail(Request $request) {
    $validator = Validator::make($request->all(), [
        'email' => 'required',
    ]);
   
    if ($validator->fails()) {
        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
    }

    // Find user by mobile
    $user = User::where('email', $request->email)->first();
 
    // Check if the user exists
    if (!$user) {
        
        User::create(['email' => $request->email ]);
         $user = User::where('email', $request->email)->first();
          $success['token'] = $user->createToken('UserApp')->plainTextToken;
    $success['userId'] = $user->id;
        return response()->json([
            'success' => true,
            'message' => 'login successfully',
            'status' => 1,
             'data' => $success   
        ]);
    }
  $success['token'] = $user->createToken('UserApp')->plainTextToken;
    $success['userId'] = $user->id;
    // Check if user has a name and email
    if (is_null($user->name) && is_null($user->mobile)) {
        return response()->json([
            'success' => true,
            'message' => 'login successfully',
            'status' => 1,
             'data' => $success   
                  
        ]);
    }

    // Create a token for the authenticated user
  

    return response()->json([
        'success' => true,
        'message' => 'User logged in successfully',
        'status' => 1,
        'data' => $success       
    ]);
}
    public function Register(Request $request){
          $validator = Validator::make($request->all(), [
            'referralCode' => 'nullable|string|max:8',
            'mobile' => 'required|numeric|exists:users,mobile',
            'name' => 'required|string|min:3|max:16', // Added a minimum length
            'email' => 'required|email|unique:users,email', // Adjusted for updates
        ]);
    
        if ($validator->fails()) {
            return response()->json(['success' => false,'message' => $validator->errors()->first()], 400);
        }
        
            $referral = User::Where('referral_code',$request->referralCode)->first();
            
            $user = User::where('mobile',$request->mobile)->first();

            if ($user) {
   
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'role_id' => 2,
                'profile_image_id' => 2,
                'referral_user_id' => $referral->id ?? 0,
            ]);
                    
                $success['token'] = $user->createToken('UserApp')->plainTextToken;
                $success['userId'] = $user->id;
                

                $response = [
                    'success' => true,
                    'message' => 'User Register successfully',
                    'status' => 1,
                    'data' => $success       
                ];
            
                return response()->json($response, 200);
                    
                }
    }
    
    public function Logout(Request $request) {
   
    $user = $request->user();

    if ($user) {
        // Revoke the current access token
        $request->user()->currentAccessToken()->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'User logged out successfully.'
        ]);
    }

    return response()->json(['success' => false, 'message' => 'User not authenticated.'], 401);
}

    public function ChangePassword(Request $request){
         try {
             
                $validator = Validator::make($request->all(), [
                'password' => 'required|string',
                'confirmPassword' => 'required|string|same:newPassword',
                'userId' => 'required|exists:users,id',
                'newPassword' => 'required|string|min:8',
                
            ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }
             
           $user = User::find($request->userId);

    // Check if the provided password matches the user's current password
    if (!Hash::check($request->password, $user->password)) {
        return response()->json([ 'success' => false, 'message' => 'Current password is incorrect.'], 400);
    }

    // Update the user's password
    $user->password = Hash::make($request->newPassword);
    $user->save();

    return response()->json([  'success' => true,  'message' => 'Password changed successfully.'], 200);
        }catch (Exception $e) {
            return response()->json(['error' => 'API request failed: ' . $e->getMessage()], 500);
        }
    }



















}

