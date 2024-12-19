<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\{User,Payin,Lucky12Result,Lucky12Bet,Withdraw};
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PayinController extends Controller
{
    
        public function PayinIndex(): View
        {
            $payin = Payin::with('user')->latest()->paginate(10);
             return view('payin.index')->with('payin',$payin);
        }
        public function redirect_success(){
		      return view ('success');	
	    }
    
    
    
}