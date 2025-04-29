<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CrudCategoryController extends Controller
{
    /**
     * Hiển thị danh sách danh mục
     */
    public function listCategory(Request $request)
    {
        $query = Category::query();

        if ($search = $request->input('search')) {
            $query->where('category_name', 'like', "%$search%");
        }

        $categories = $query->paginate(10);
        return view('crud_category.list', compact('categories'));

    }

    /**
     * Hiển thị form tạo danh mục
     */
    public function createCategory()
    {
        return view('crud_category.create');
    }

    /**
     * Xử lý form tạo danh mục
     */
    public function postCategory(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'category_description' => 'nullable|string',
            'category_status' => 'required|boolean',
        ]);

        Category::create([
            'category_name' => $request->category_name,
            'category_description' => $request->category_description,
            'category_status' => $request->category_status,
        ]);

        return redirect()->route('categories.list')->with('success', 'Danh mục đã được thêm thành công');
    }

    /**
     * Hiển thị form cập nhật danh mục
     */
    public function updateCategory($category_id)
    {
        $category = Category::findOrFail($category_id);
        return view('crud_category.update', compact('category'));
    }

    /**
     * Xử lý form cập nhật danh mục
     */
    public function postUpdateCategory(Request $request, $category_id)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'category_description' => 'nullable|string',
            'category_status' => 'required|boolean',
        ]);

        $category = Category::findOrFail($category_id);

        $category->update([
            'category_name' => $request->category_name,
            'category_description' => $request->category_description,
            'category_status' => $request->category_status,
        ]);

        return redirect()->route('categories.list')->with('success', 'Cập nhật danh mục thành công');
    }

    /**
     * Xem chi tiết danh mục
     */
    public function readCategory($category_id)
    {
        $category = Category::with('category')->findOrFail($category_id);
        return view('crud_category.read', compact('category'));
    }

    /**
     * Xóa danh mục
     */
    public function deleteCategory($category_id)
    {
        $category = Category::findOrFail($category_id);

        // Nếu cần, kiểm tra xem danh mục có sản phẩm không, tránh xóa nếu có
        if ($category->products()->count() > 0) {
            return redirect()->route('categories.list')->with('error', 'Không thể xóa danh mục vì đang chứa sản phẩm');
        }

        $category->delete();
        return redirect()->route('categories.list')->with('success', 'Danh mục đã được xóa');
    }
}
