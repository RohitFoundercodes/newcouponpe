<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\{User,Banner,SiteContent,Payin,Withdraw};
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SettingController extends Controller
{
    
    public function SiteContents($slug)
    {
        
        $content = SiteContent::where('slug', $slug)->firstOrFail();
      
        return view('settings.siteContent')->with('content',$content);
    }
    
}