<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account_Admin;
use App\Models\LevelUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CrudAccountAdminController extends Controller
{
    public function listAccountAdmin(Request $request)
    {
        $query = Account_Admin::with('level');
        // Hiển thị theo từ cũ đến mới
        // $query->orderBy('product_id', 'asc');

        // Hiển thị theo từ mới đến cũ
        $query->orderBy('user_id', 'desc');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            });
        }

        $accounts = $query->paginate(5)->appends($request->only('search'));

        return view('crud_account_admin.list', compact('accounts'));
    }

    public function createAccountAdmin()
    {
        $levels = LevelUser::all();
        return view('crud_account_admin.create', compact('levels'));
    }

    public function postAccountAdmin(Request $request)
    {
        $request->validate([
            'full_name' => ['required', 'string', 'max:30', 'regex:/^[\pL\s\-]+$/u'],
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'phone' => 'required|string|max:15',
            'gender' => 'required|string',
            'date' => 'required|date',
            'address' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'level_id' => 'required|exists:level_user,level_id',
            'status' => 'required|boolean',
        ], [
            'full_name.required' => 'Vui lòng nhập họ và tên.',
            'full_name.string' => 'Họ và tên phải là chuỗi ký tự.',
            'full_name.max' => 'Họ và tên không được vượt quá 30 ký tự.',
            'full_name.regex' => 'Họ và tên chỉ được chứa chữ cái, khoảng trắng và dấu gạch ngang.',

            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email đã được sử dụng.',

            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.string' => 'Mật khẩu phải là chuỗi ký tự.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',

            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.string' => 'Số điện thoại phải là chuỗi ký tự.',
            'phone.max' => 'Số điện thoại không được vượt quá 15 ký tự.',

            'gender.required' => 'Vui lòng chọn giới tính.',
            'gender.string' => 'Giới tính không hợp lệ.',

            'date.required' => 'Vui lòng nhập ngày sinh.',
            'date.date' => 'Ngày sinh không đúng định dạng.',

            'address.required' => 'Vui lòng nhập địa chỉ.',
            'address.string' => 'Địa chỉ phải là chuỗi ký tự.',
            'address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',

            'avatar.image' => 'File ảnh đại diện không hợp lệ.',
            'avatar.mimes' => 'Ảnh đại diện phải có định dạng jpg, jpeg, png hoặc gif.',
            'avatar.max' => 'Ảnh đại diện không được vượt quá 2MB.',

            'level_id.required' => 'Vui lòng chọn cấp bậc.',
            'level_id.exists' => 'Cấp bậc không tồn tại.',

            'status.required' => 'Vui lòng chọn trạng thái.',
            'status.boolean' => 'Trạng thái không hợp lệ.',
        ]);

        $avatar = $request->file('avatar') ? $request->file('avatar')->store('avatars', 'public') : null;

        Account_Admin::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'gender' => $request->gender,
            'date' => $request->date,
            'address' => $request->address,
            'avatar' => $avatar,
            'level_id' => $request->level_id,
            'status' => $request->status,
            'about' => $request->about,
        ]);

        return redirect()->route('accountAdmin.list')->with('success', 'Tài khoản đã được tạo thành công');
    }



    public function updateAccountAdmin($account_id)
    {
        $account = Account_Admin::find($account_id);
        if (!$account) {
            return redirect()->route('accountAdmin.list')->with('error', 'Tài khoản không còn tồn tại.');
        }

        $levels = LevelUser::all();
        return view('crud_account_admin.update', compact('account', 'levels'));
    }

    public function postUpdateAccountAdmin(Request $request, $account_id)
    {
        $request->validate([
            'full_name' => ['required', 'string', 'max:100', 'regex:/^[\pL\s\-]+$/u'],
            'email' => 'required|email|unique:users,email,' . $account_id . ',user_id',
            'phone' => ['required', 'regex:/^[0-9\-\+\s\(\)]+$/', 'min:8', 'max:15'],
            'gender' => 'required|in:male,female,other',
            'date' => 'required|date|before:today',
            'address' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'level_id' => 'required|exists:level_user,level_id',
            'status' => 'required|boolean',
        ], [
            'full_name.required' => 'Vui lòng nhập họ tên.',
            'full_name.max' => 'Họ tên không được vượt quá 100 ký tự.',
            'full_name.regex' => 'Họ tên chỉ được chứa chữ cái, khoảng trắng và dấu gạch nối.',

            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email này đã được sử dụng.',

            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.regex' => 'Số điện thoại không hợp lệ.',
            'phone.min' => 'Số điện thoại quá ngắn.',
            'phone.max' => 'Số điện thoại quá dài.',

            'gender.required' => 'Vui lòng chọn giới tính.',
            'gender.in' => 'Giới tính không hợp lệ.',

            'date.required' => 'Vui lòng nhập ngày sinh.',
            'date.date' => 'Ngày sinh không hợp lệ.',
            'date.before' => 'Ngày sinh phải trước ngày hôm nay.',

            'address.required' => 'Vui lòng nhập địa chỉ.',
            'address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',

            'avatar.image' => 'File ảnh đại diện không hợp lệ.',
            'avatar.mimes' => 'Ảnh đại diện phải là định dạng jpg, jpeg, png hoặc gif.',
            'avatar.max' => 'Ảnh đại diện không được vượt quá 2MB.',

            'level_id.required' => 'Vui lòng chọn quyền tài khoản.',
            'level_id.exists' => 'Cấp bậc tài khoản không tồn tại.',

            'status.required' => 'Vui lòng chọn trạng thái.',
            'status.boolean' => 'Trạng thái phải là giá trị hợp lệ.',
        ]);

        $account = Account_Admin::find($account_id);
        if (!$account) {
            return redirect()->route('accountAdmin.list')->with('error', 'Tài khoản không còn tồn tại.');
        }

        // Nếu có ảnh mới, lưu ảnh mới, nếu không thì giữ nguyên ảnh cũ
        $avatar = $request->file('avatar')
            ? $request->file('avatar')->store('avatars', 'public')
            : $account->avatar;

        $account->update([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'date' => $request->date,
            'address' => $request->address,
            'avatar' => $avatar,
            'level_id' => $request->level_id,
            'status' => $request->status,
            'about' => $request->about,
        ]);

        return redirect()->route('accountAdmin.list')->with('success', 'Tài khoản đã được cập nhật thành công');
    }


    public function readAccountAdmin($account_id)
    {
        $account = Account_Admin::with('level')->find($account_id);
        if (!$account) {
            return redirect()->route('accountAdmin.list')->with('error', 'Tài khoản không còn tồn tại.');
        }

        return view('crud_account_admin.read', compact('account'));
    }

    public function deleteAccountAdmin($account_id)
    {
        $account = Account_Admin::find($account_id);
        if (!$account) {
            return redirect()->route('accountAdmin.list')->with('error', 'Tài khoản đã bị xóa hoặc không tồn tại.');
        }

        if ($account->avatar) {
            Storage::disk('public')->delete($account->avatar);
        }

        $account->delete();

        return redirect()->route('accountAdmin.list')->with('success', 'Tài khoản đã được xóa');
    }
}
