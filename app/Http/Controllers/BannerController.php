<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\{User,Banner,Lucky12Bet,Payin,Withdraw};
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BannerController extends Controller
{
    
    public function BannerIndex(){
        $banner = Banner::all();
        return view('banner.index')->with('banner',$banner);
    }
    
    public function BannerStore(Request $request)
    {
    // Validate the request
 
    // Handle the uploaded file
    if ($request->hasFile('image')) {
        $file = $request->file('image');
        
        // Define a unique name for the image
        $filename = time() . '_' . $file->getClientOriginalName();

        // Store the image in the public directory
        $file->move(public_path('/assets/banner'), $filename); // Move to public/banners
        
        // Create a new Banner instance
        $banner = new Banner();
        $banner->image =  $filename; // Store the path
        $banner->save(); // Save the banner

        return redirect()->back()->with('success', 'Banner created successfully.');
    }

    return redirect()->back()->with('error', 'Failed to upload the image.');
    }

    
    public function BannerActive($id){
        
        $userStatus = Banner::where('id', $id)->update([
                'status' => 1
        ]);
        
        return redirect()->back();
    }
    
    public function BannerInactive($id){
        
        $userStatus = Banner::where('id', $id)->update([
                'status' => 0
        ]);
        
        return redirect()->back();
    }
    
    
    public function BannerDestroy($id)
    {
        try {
            $user = Banner::findOrFail($id); 
            $user->delete(); 
            return redirect()->back()->with('success','Banner deleted.');
          
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Banner not found.');
        }
    }
}