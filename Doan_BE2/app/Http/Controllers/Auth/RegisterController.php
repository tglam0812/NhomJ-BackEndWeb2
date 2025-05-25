<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Flasher\Prime\FlasherInterface;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    //protected $redirectTo = '/home';
    protected $redirectTo =  '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest');
    }
    public function showRegistrationForm()
    {
        return view('auth.register');
    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
   protected function validator(array $data)
{
    // Trim các ký tự khoảng trắng mở rộng
    $trimWhitespace = function ($value) {
        return rtrim($value, " \t\n\r\0\x0B\x{3000}");
    };

    // Áp dụng trim cho các trường
    $data['full_name'] = $trimWhitespace($data['full_name']);
    $data['email'] = $trimWhitespace($data['email']);
    $data['password'] = $trimWhitespace($data['password']);

    // Rule: Không được chứa khoảng trắng
    $noWhitespace = function ($attribute, $value, $fail) {
        if (preg_match('/[\s\x{3000}]/u', $value)) {
            $fail("Trường :attribute không được chứa khoảng trắng.");
        }
    };

    // Rule: Chỉ cho phép chữ cái và số cho full_name
    $alphaNumOnly = function ($attribute, $value, $fail) {
        if (!preg_match('/^[a-zA-Z0-9]+$/', $value)) {
            $fail("Trường :attribute chỉ được chứa chữ cái và số.");
        }
    };

    return Validator::make($data, [
        'full_name' => ['required', 'string', 'max:255', $alphaNumOnly],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users', $noWhitespace],
        'password' => ['required', 'string', 'min:6', 'confirmed', $noWhitespace],
    ], [
        'full_name.required' => 'Tên đăng nhập sai hoặc quá dài',
        'full_name.max' => 'Tên đăng nhập sai hoặc quá dài',
        'full_name.*' => 'Tên đăng nhập chỉ được sử dụng chữ cái và số',
        'email.required' => 'Email phải có @',
        'email.email' => 'Email phải có @',
        'email.unique' => 'Email này đã được đăng ký',
        'password.required' => 'Password phải tối thiểu 6 ký tự và không được có khoảng trắng',
        'password.min' => 'Password phải tối thiểu 6 ký tự và không được có khoảng trắng',
        'password.confirmed' => 'Mật khẩu xác nhận không khớp',
    ]);
}
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */

    protected function create(array $data)
    {
        return User::create([
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => '',
            'gender'=> '',
            'date'=> '2025-04-15',
            'address' => 'tp.HCM',
            'avatar'=> '',
            'level_id'=> '2',//măc định user = 2
            'status'=> 'active',
            'about'=> ''
        ]); //hehe
    }
}