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

class OrderPlaceController extends Controller
{
    
      public function OrderIndex(): View
        {
            
          
            return view('order.index');
        }
    
    
}