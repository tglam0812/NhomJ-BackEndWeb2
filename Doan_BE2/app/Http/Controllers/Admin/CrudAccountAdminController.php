<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account_Admin;
use App\Models\LevelUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CrudAccountAdminController extends Controller
{
    /**
     * Hiển thị danh sách tài khoản quản trị
     */
    public function listAccountAdmin(Request $request)
    {
        $query = Account_Admin::with('level');

        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('full_name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%");
            });
        }

        $accounts = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('crud_account_admin.list', compact('accounts'));
    }
    /**
     * Hiển thị form tạo tài khoản
     */
    public function createAccountAdmin()
    {
        $levels = LevelUser::all();
        return view('crud_account_admin.create', compact('levels'));
    }

    /**
     * Xử lý tạo tài khoản
     */
    public function postAccountAdmin(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'phone' => 'required|string|max:15',
            'gender' => 'required|string',
            'date' => 'required|date',
            'address' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'level_id' => 'required|exists:level_user,level_id',
            'status' => 'required|boolean',
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

    /**
     * Hiển thị form sửa tài khoản
     */
    public function updateAccountAdmin($account_id)
    {
        $account = Account_Admin::findOrFail($account_id);
        $levels = LevelUser::all();
        return view('crud_account_admin.update', compact('account', 'levels'));
    }

    /**
     * Xử lý cập nhật tài khoản
     */
    public function postUpdateAccountAdmin(Request $request, $account_id)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $account_id,
            'phone' => 'required|string|max:15',
            'gender' => 'required|string',
            'date' => 'required|date',
            'address' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'level_id' => 'required|exists:level_user,level_id',
            'status' => 'required|boolean',
        ]);

        $account = Account_Admin::findOrFail($account_id);
        $avatar = $request->file('avatar') ? $request->file('avatar')->store('avatars', 'public') : $account->avatar;

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

    /**
     * Xem chi tiết tài khoản
     */
    public function readAccountAdmin($account_id)
    {
        $account = Account_Admin::with('level')->findOrFail($account_id);
        return view('crud_account_admin.read', compact('account'));
    }

    /**
     * Xóa tài khoản
     */
    public function deleteAccountAdmin($account_id)
    {
        $account = Account_Admin::findOrFail($account_id);
        
        if ($account->avatar) {
            Storage::disk('public')->delete($account->avatar);
        }

        $account->delete();

        return redirect()->route('accountAdmin.list')->with('success', 'Tài khoản đã được xóa');
    }
}
