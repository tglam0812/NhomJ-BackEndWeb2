<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LevelUser;
use Illuminate\Http\Request;

class CrudLevelController extends Controller
{
    /**
     * Hiển thị danh sách cấp bậc người dùng
     */
    public function listLevel()
    {
        $levels = LevelUser::all();
        return view('crud_level.list', compact('levels'));
    }

    /**
     * Hiển thị form tạo cấp bậc
     */
    public function createLevel()
    {
        return view('crud_level.create');
    }

    /**
     * Xử lý tạo cấp bậc
     */
    public function postLevel(Request $request)
    {
        $request->validate([
            'level_name' => 'required|string|max:255|unique:level_user,level_name',
        ]);

        LevelUser::create([
            'level_name' => $request->level_name,
        ]);

        return redirect()->route('levelAdmin.list')->with('success', 'Cấp bậc đã được tạo thành công');
    }

    /**
     * Hiển thị form sửa cấp bậc
     */
    public function updateLevel($level_id)
    {
        $level = LevelUser::findOrFail($level_id);
        return view('crud_level.update', compact('level'));
    }

    /**
     * Xử lý cập nhật cấp bậc
     */
    public function postUpdateLevel(Request $request, $level_id)
    {
        $request->validate([
            'level_name' => 'required|string|max:255|unique:level_user,level_name,' . $level_id,
        ]);

        $level = LevelUser::findOrFail($level_id);
        $level->update([
            'level_name' => $request->level_name,
        ]);

        return redirect()->route('levelAdmin.list')->with('success', 'Cấp bậc đã được cập nhật thành công');
    }

    /**
     * Xóa cấp bậc
     */
    public function deleteLevel($level_id)
    {
        $level = LevelUser::findOrFail($level_id);
        $level->delete();

        return redirect()->route('levelAdmin.list')->with('success', 'Cấp bậc đã được xóa');
    }
}
