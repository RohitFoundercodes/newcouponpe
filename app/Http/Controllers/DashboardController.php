<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\{User,Lucky12Bet,Lucky12Result,Payin,Withdraw};
use Carbon\Carbon;

class DashboardController extends Controller
{
    
    public function Dashboard(){
        
        $totalUser = User::whereNot('role_id',1)->count();
        $activeUser = User::whereNot('status',0)->count();
        $totalUser = User::whereNot('role_id',1)->count();
        $totalPayin = Payin::where('payment_status',2)->sum('amount');
        $todayPayin = Payin::whereDate('created_at', today())->sum('amount');
        $totalWithdraw = Withdraw::where('payment_status',2)->sum('amount');
       $todayWithdraw = Withdraw::whereDate('created_at', today())->sum('amount');
        
        return view('dashboard')
        ->with('totalUser',$totalUser)
        ->with('activeUser',$activeUser)
        ->with('totalPayin',$totalPayin)
        ->with('todayPayin',$todayPayin)
        ->with('totalWithdraw',$totalWithdraw)
        ->with('todayWithdraw',$todayWithdraw);
    }
    
    
}