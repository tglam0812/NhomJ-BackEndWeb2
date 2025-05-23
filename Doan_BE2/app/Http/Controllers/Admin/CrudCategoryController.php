<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

        $categories = $query->paginate(10)->appends($request->only('search'));
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
        $category = Category::find($category_id);

        if (!$category) {
            return redirect()->route('categories.list')->with('error', 'Danh mục không tồn tại hoặc đã bị xóa');
        }

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

    /**
     * Xem chi tiết danh mục
     */
    public function readCategory($category_id)
    {
        $category = Category::find($category_id);

        if (!$category) {
            return redirect()->route('categories.list')->with('error', 'Danh mục không tồn tại hoặc đã bị xóa');
        }

        return view('crud_category.read', compact('category'));
    }

    /**
     * Xóa danh mục
     */
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
