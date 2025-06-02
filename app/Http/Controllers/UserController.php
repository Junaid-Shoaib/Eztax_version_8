<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    //

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = User::query();

            if ($request->name) {
                $query->where('name', $request->name);
            }

            if ($request->email) {
                $query->where('email', $request->email);
            }

            if ($request->role !== null && $request->role !== 'all') {
                $query->where('is_admin', $request->role);
            }

            return DataTables::of($query)
                ->addColumn('role', function ($user) {
                    return $user->is_admin ? 'Admin' : 'User';
                })
                ->make(true);
        }

        $users = User::all(); 

        return view('user.index', compact('users'));
    }


    public function create(){
        return view('user.create');
    }

    public function store(Request $request){
        $request->validate( [ 
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'is_admin' => 'required|in:0,1',
            'password' => 'required|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => $request->is_admin,
            'location' => $request->location,
        ]);
          Storage::disk('public')->makeDirectory($user->id);
        
        return redirect()->route('users')->with('success','User Created Successfully');
    }
  
}