<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class InformationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function info(Request $request)
    {
        $user = Auth::user();
        return view('auth.information', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id); //tim thong tin dua theo user id trong bang User
        $this->validate($request,[
            'full_name' => 'required|max:120',
            'phone'     => ['required', 'regex:/^\+84[0-9]{9}$/', 'not_regex:/[a-z]/'
    ]
        ]);
        $user->full_name = $request->full_name;
        $user->phone    = $request->phone;
        $user->gender   = '';
        $user->date     = $request->date;
        $user->address  = $request->address;
        $user->about    = '';
       // set avatar, kiểm tra và đổi avt
        if ($request->hasFile('avatar')) {
            $file = $request->avatar;
            $extension = "jpg";
            $filename  = $user->user_id. '.' . $extension;//$file->getClientOriginalName();//lấy tên file
            $user->avatar  = $filename;
            $request->file('avatar')->move('assets/images/avt/',  $user->avatar);  //Lưu vào thư mục
        }
        if($user->save()) {
            return redirect()->back()->with('success', 'Cập nhật thành công!');
        }
        else{
            return redirect()->back()->with('error', 'Cập nhật thất bại!');
        }
    }
    public function showresetpassword(Request $request)
    {
        $user = Auth::user();
        return view('auth.resetpassword', compact('user'));
    }
    public function resetpassword(Request $request, $id)
    {
        // 1. Tìm user
        $user = User::findOrFail($id);

        // 2. Validate dữ liệu đầu vào
        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|min:5',
            'confirm_password' => 'required|same:new_password',
        ]);

        // 3. Kiểm tra mật khẩu cũ
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'Mật khẩu hiện tại không đúng!');
        }

        // 4. Cập nhật mật khẩu mới
        $user->password = Hash::make($request->new_password);
        $user->save();

        // 5. Thông báo thành công
        //return redirect()->back()->with('success', 'Cập nhật mật khẩu thành công!');
        //return redirect()->route('home'); // Chuyển hướng về trang chủ
        return redirect('/login')->with('success', 'Cập nhật mật khẩu thành công! Vui lòng đăng nhập lại.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
