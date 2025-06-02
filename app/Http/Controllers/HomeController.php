<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Notice;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $total_client = Client::where('location', auth()->user()->location)->count();
        $total_notice = Notice::where('user_id', auth()->user()->id)->count();
        $notice_Comp_count = Notice::where('user_id', auth()->user()->id)->where('status', 1)->count();
        $notice_Pend_count = Notice::where('user_id', auth()->user()->id)->where('status', 0)->count();

        // Calculate progress in backend
        $progress = $total_notice > 0 ? round(($notice_Comp_count / $total_notice) * 100, 1) : 0;

        return view('dashboard', compact(
            'total_client',
            'total_notice',
            'notice_Comp_count',
            'notice_Pend_count',
            'progress'
        ));   
    }

     public function adminHome()
    {
        
        return view('admin.home');
    }
}
