<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Wishlist;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('guest')->except('logout');
       // $this->middleware('auth')->only('logout');
    }
    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        $user = Auth::user();  // Lấy user vừa đăng nhập

        // Kiểm tra quyền
        if ($user->level_id == 1) {
                return redirect()->intended('/products');  // Admin vào trang quản lý sản phẩm
            }

            // Nếu không phải admin, vào trang chủ hoặc trang khác
            return redirect()->intended('/');
        }

        return back()->withInput();
    }
    //logout
    // public function logout()
    // {
    //     Auth::logout();
    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();
    //     return redirect('/');
    // }
    public function logout(Request $request)
    {
        auth()->logout(); // Đăng xuất người dùng
        $request->session()->invalidate(); // Làm mới session
        $request->session()->regenerateToken(); // Tạo token mới

        return redirect()->route('home'); // Chuyển hướng về trang chủ
    }

    protected function authenticated(Request $request, $user)
    {
        $wishlistCount = Wishlist::where('user_id', $user->id)->count();
        session(['wishlist_count' => $wishlistCount]);

        if ($user->level_id == 1) {
            return redirect()->route('categories.list'); // Admin → CRUD sản phẩm
        } else {
            return redirect()->intended('/');   
        }
    }
}
