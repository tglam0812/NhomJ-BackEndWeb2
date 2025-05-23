<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CrudCategoryController extends Controller
{
    public function listCategory(Request $request)
    {
        $query = Category::query();

        if ($search = $request->input('search')) {
            $query->where('category_name', 'like', "%$search%");
        }

        $categories = $query->paginate(10)->appends($request->only('search'));
        return view('crud_category.list', compact('categories'));
    }

    public function createCategory()
    {
        return view('crud_category.create');
    }

    public function postCategory(Request $request)
    {
        $request->validate([
            'category_name' => [
                'required',
                'string',
                'max:30',
                'regex:/^[a-zA-Z0-9\sÀ-ỹàáạảãâầấậẩẫăằắặẳẵèéẹẻẽêềếệểễìíịỉĩòóọỏõôồốộổỗơờớợởỡùúụủũưừứựửữỳýỵỷỹđĐ]+$/u'
            ],
            'category_description' => 'nullable|string',
            'category_status' => 'required|boolean',
        ], [
            'category_name.required' => 'Tên danh mục không được để trống.',
            'category_name.max' => 'Tên danh mục không được vượt quá 30 ký tự.',
            'category_name.regex' => 'Tên danh mục không được chứa ký tự đặc biệt.',
            'category_status.required' => 'Trạng thái danh mục là bắt buộc.',
            'category_status.boolean' => 'Trạng thái danh mục không hợp lệ.',
        ]);

        Category::create([
            'category_name' => $request->category_name,
            'category_description' => $request->category_description,
            'category_status' => $request->category_status,
        ]);

        return redirect()->route('categories.list')->with('success', 'Danh mục đã được thêm thành công');
    }

    public function updateCategory($category_id)
    {
        $category = Category::find($category_id);

        if (!$category) {
            return redirect()->route('categories.list')->with('error', 'Danh mục không tồn tại hoặc đã bị xóa');
        }

        return view('crud_category.update', compact('category'));
    }

    public function postUpdateCategory(Request $request, $category_id)
    {
        $request->validate([
            'category_name' => [
                'required',
                'string',
                'max:30',
                'regex:/^[a-zA-Z0-9\sÀ-ỹàáạảãâầấậẩẫăằắặẳẵèéẹẻẽêềếệểễìíịỉĩòóọỏõôồốộổỗơờớợởỡùúụủũưừứựửữỳýỵỷỹđĐ]+$/u'
            ],
            'category_description' => 'nullable|string',
            'category_status' => 'required|boolean',
        ], [
            'category_name.required' => 'Tên danh mục không được để trống.',
            'category_name.max' => 'Tên danh mục không được vượt quá 30 ký tự.',
            'category_name.regex' => 'Tên danh mục không được chứa ký tự đặc biệt.',
            'category_status.required' => 'Trạng thái danh mục là bắt buộc.',
            'category_status.boolean' => 'Trạng thái danh mục không hợp lệ.',
        ]);

        $category = Category::find($category_id);

        if (!$category) {
            return redirect()->route('categories.list')->with('error', 'Không thể cập nhật vì danh mục đã bị xóa');
        }

        $category->update([
            'category_name' => $request->category_name,
            'category_description' => $request->category_description,
            'category_status' => $request->category_status,
        ]);

        return redirect()->route('categories.list')->with('success', 'Cập nhật danh mục thành công');
    }

    public function readCategory($category_id)
    {
        $category = Category::find($category_id);

        if (!$category) {
            return redirect()->route('categories.list')->with('error', 'Danh mục không tồn tại hoặc đã bị xóa');
        }

        return view('crud_category.read', compact('category'));
    }

    public function deleteCategory($category_id)
    {
        $category = Category::find($category_id);

        if (!$category) {
            return redirect()->route('categories.list')->with('warning', 'Danh mục đã bị xóa trước đó');
        }

        // Xóa toàn bộ sản phẩm thuộc danh mục
        $category->products()->delete();

        // Xóa danh mục
        $category->delete();

        return redirect()->route('categories.list')->with('success', 'Danh mục và các sản phẩm đã được xóa');
    }
}
