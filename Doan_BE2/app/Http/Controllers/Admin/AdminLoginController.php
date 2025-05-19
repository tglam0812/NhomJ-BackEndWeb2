<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Controllers\Controller;


class AdminLoginController extends Controller
{
    public function showLoginForm()
    {
        // Trả về view form đăng nhập
        return view('admin.login'); 
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email không tồn tại.']);
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Mật khẩu không đúng.']);
        }

        if ($user->level_id != 1) {
            return back()->withErrors(['email' => 'Bạn không có quyền truy cập.']);
        }

        Auth::login($user);
        return redirect()->route('admin.dashboard');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }
}
