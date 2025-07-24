<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class GenaralController extends Controller
{
    public function index()
    {
        
    
        return view('web.homepage');
    }

    public function home()
    {
        if (Auth::check()) {

            return redirect()->route('setDashboard');
        }
        else{
            return redirect()->route('index');
        }
    }

    public function setDashboard()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $role = $user->roles->pluck('name')->first();

            if ($role === 'Admin') {
                return redirect()->route('getAdminDashboard');
            } 
            else{

                return redirect()->route('userlogin');
            }
        }
    }

    public function userLogin()
    {
        return view('auth.userlogin');
    }


    public function userRegister()
    {
        return view('auth.userRegister');
    }

    public function registerUser(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:15',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = new User();
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->phone = $validatedData['phone'];
        $user->password = Hash::make($validatedData['password']);

        $user->assignRole('User');
        $user->save();
        Auth::login($user);

        return redirect()->route('index')->with('success', 'Registration successful!');
    }
}
