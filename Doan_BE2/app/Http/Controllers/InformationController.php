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
        $user = User::findOrFail($id); // Tìm thông tin user theo ID

try {
    $this->validate($request, [
        'full_name' => 'required|max:120',
        'phone' => [
            'required',
            'regex:/^0[0-9]{9}$/', // Bắt đầu bằng 0, theo sau là 9 chữ số
            'numeric' // Đảm bảo chỉ chứa số
        ],
        'date' => [
            'required',
            'date', // Kiểm tra định dạng ngày
            'before:today', // Phải là ngày trước hiện tại
            'date_format:Y-m-d' // Định dạng YYYY-MM-DD
        ],
        'address' => 'required|string|max:255', // Bắt buộc nhập địa chỉ
        'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048' // Validate file ảnh
    ], [
        'full_name.required' => 'Vui lòng điền đầy đủ họ tên.',
        'phone.required' => 'Vui lòng điền số điện thoại.',
        'phone.regex' => 'Số điện thoại phải bắt đầu bằng 0 và có đúng 10 chữ số.',
        'phone.numeric' => 'Số điện thoại chỉ được chứa số.',
        'date.required' => 'Vui lòng điền ngày tháng năm sinh.',
        'date.date' => 'Ngày tháng năm sinh không đúng định dạng.',
        'date.before' => 'Ngày tháng năm sinh phải là ngày trong quá khứ.',
        'date.date_format' => 'Ngày tháng năm sinh phải có định dạng YYYY-MM-DD.',
        'address.required' => 'Vui lòng điền địa chỉ.', // Thêm thông báo lỗi cho address
        'avatar.image' => 'File avatar phải là ảnh (jpeg, png, jpg).',
    ]);

    // Cập nhật thông tin user
    $user->full_name = $request->full_name;
    $user->phone = $request->phone;
    $user->gender = $request->gender ?? ''; // Sử dụng null coalescing để tránh lỗi
    $user->date = $request->date;
    $user->address = $request->address; // Không cần ?? vì address đã required
    $user->about = $request->about ?? '';

    // Xử lý upload avatar
    if ($request->hasFile('avatar')) {
        // Xóa avatar cũ nếu tồn tại
        if ($user->avatar && file_exists(public_path('assets/images/avt/' . $user->avatar))) {
            unlink(public_path('assets/images/avt/' . $user->avatar));
        }

        $file = $request->file('avatar');
        $extension = $file->getClientOriginalExtension(); // Lấy extension gốc
        $filename = $user->user_id . '_' . time() . '.' . $extension; // Thêm timestamp để tránh trùng
        $file->move(public_path('assets/images/avt'), $filename);
        $user->avatar = $filename;
    }

    if ($user->save()) {
        return redirect()->back()->with('success', 'Cập nhật thành công!');
    } else {
        return redirect()->back()->with('error', 'Cập nhật thất bại!');
    }

    } catch (\Illuminate\Validation\ValidationException $e) 
    {
    return redirect()->back()->withErrors($e->errors())->withInput()->with('error', 'Vui lòng điền đầy đủ và đúng định dạng các thông tin!');
    } catch (\Exception $e) {
    return redirect()->back()->with('error', 'Cập nhật thất bại: ' . $e->getMessage());
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
