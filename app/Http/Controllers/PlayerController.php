<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\{User,Lucky12Result,Lucky12Bet,Payin,Withdraw};
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PlayerController extends Controller
{

    public function PlayerIndex(): View
    {
        $users = User::latest()->paginate(10);
        return view('players.index')->with('users',$users);
    }
    
    public function PlayerWalletAdd(Request $request,$id){
      
        $request->validate([
            'wallet' => 'required|numeric',
        ]);
        
       
        $userWallet = User::where('id',$id)->update([
                'wallet' => DB::raw('wallet + ' . $request->wallet)
        ]);
        
        if($userWallet){
            
            $now = Carbon::now();
            $time = Carbon::parse($now)->format('Ymd');
            $transaction_id = $time.'01'.rand(0000,9999);
            
            
            Payin::create([
                'user_id' => $id,
                'amount' => $request->wallet,
                'transaction_id' => $transaction_id,
                'paymode_id' => 4,
                'payment_status' => 2   // 2 = seccess
                ]);
                
                
            return redirect()->back();
        }
        
       
    }
    
    public function PlayerWalletSub(Request $request,$id){
        $request->validate([
            'wallet' => 'required|numeric',
        ]);
        
        $userWallet = User::where('id', $id)->where('wallet', '>', 0)
        ->update([
                'wallet' => DB::raw('wallet - ' . $request->wallet)
        ]);
        
        if($userWallet){
            
            $now = Carbon::now();
            $time = Carbon::parse($now)->format('Ymd');
            $transaction_id = $time.'02'.rand(0000,9999);
            
            
            Withdraw::create([
                'user_id' => $id,
                'amount' => $request->wallet,
                'transaction_id' => $transaction_id,
                'paymode_id' => 4,
                'payment_status' => 2   // 2 = seccess
                ]);
                
                
            return redirect()->back();
        }

        return redirect()->back()->with('error', 'Insufficient wallet balance');
        
    }
    
    public function PlayerActive($id){
        
        $userStatus = User::where('id', $id)->update([
                'status' => 1
        ]);
        
        return redirect()->back();
    }
    
    public function PlayerInactive($id){
        
        $userStatus = User::where('id', $id)->update([
                'status' => 0
        ]);
        
        return redirect()->back();
    }
    
    
    public function PlayerDetails($userId){
        
       $lucky12Bet =  Lucky12Bet::where('user_id',$userId)->latest()->paginate(10);
       
       $payin =  Payin::where('user_id',$userId)->latest()->paginate(10);
       
       $withdraw =  Withdraw::where('user_id',$userId)->latest()->paginate(10);
       
        return view('players.playerDetail')
        ->with('lucky12Bet',$lucky12Bet)
        ->with('payin',$payin)
        ->with('withdraw',$withdraw);
    }

}