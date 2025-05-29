<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;

class CrudBrandController extends Controller
{
    /**
     * Hiển thị danh sách nhà cung cấp
     */
    public function listBrand(Request $request)
    {
        $query = Brand::query();
        //search
        if ($search = $request->input('search')) {
            $query->where('brand_name', 'like', "%$search%");
        }
        $brands = $query->paginate(5)->appends($request->only('search'));
        return view('crud_brand.list', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('crud_brand.create');
    }

    /**
     * xử lý form tạo nhà cung cấp
     */
    public function createBrand(Request $request)
    {
        return view('crud_brand.create');
    }

    /**
     * Xử lý form nhà cung cấp
     */
    public function postBrand(Request $request)
    {
        $request->validate([
            'brand_name' => 'required|string|max:255',
            'brand_description' => 'nullable|string',
            'brand_status' => 'required|boolean',
        ]);

        Brand::create([
            'brand_name' => $request->brand_name,
            'brand_description' => $request->brand_description,
            'brand_status' => $request->brand_status,
        ]);

        return redirect()->route('brands.list')->with('success', 'Thương hiệu đã được thêm thành công');
    }

    /**
     * Hiển thị form cập nhật nhà cung cấp
     */
    public function updateBrand($brand_id)
    {
        $brand = Brand::find($brand_id);

        // Kiểm tra xem nhà cung cấp có tồn tại không
        if (!$brand) {
            return redirect()->route('brands.list')->with('error', 'Thương hiệu không tồn tại');
        }

        return view('crud_brand.update', compact('brand'));
    }

    /**
     * Xử lý form cập nhật nhà cung cấp
     */
    public function postUpdateBrand(Request $request, $brand_id)
    {

// Validate dữ liệu cơ bản
$request->validate([
    'brand_name' => [
        'required',
        'string',
        'max:255',
        'regex:/^[a-zA-Z0-9\s]+$/'
    ],
    'brand_description' => 'nullable|string|max:1000',
    'brand_status' => 'required|boolean',
    'updated_at' => 'required'
], [
    'brand_name.regex' => 'Tên nhà cung cấp chỉ được chứa chữ cái, số và khoảng trắng, không chứa ký tự đặc biệt.',
    'brand_description.max' => 'Mô tả thương hiệu không được vượt quá 1000 ký tự.'
]);

// Tìm nhà cung cấp
$brand = Brand::find($brand_id);

// Kiểm tra xem nhà cung cấp có tồn tại không
if (!$brand) {
    return redirect()->route('brands.list')->with('error', 'Thương hiệu không tồn tại');
}

// Kiểm tra concurrency
if ($brand->updated_at->toDateTimeString() !== $request->updated_at) {
    return back()->withInput()->with('error', 'Thương hiệu đã bị thay đổi bởi người khác. Vui lòng tải lại trang.');
}

// Cập nhật nhà cung cấp với brand_name đã được trim
$brand->update([
    'brand_name' => trim($request->brand_name),
    'brand_description' => $request->brand_description,
    'brand_status' => $request->brand_status,
]);

return redirect()->route('brands.list')->with('success', 'Cập nhật nhà cung cấp thành công');
    }

    /**
     * Xem chi tiết nhà cung cấp
     */
    public function readBrand($brand_id)
    {
        $brand = Brand::findOrFail($brand_id);
        return view('crud_brand.read', compact('brand'));
    }

    /**
     * Xóa nhà cung cấp
     */
    public function deleteBrand($brand_id)
    {
        $brand = Brand::find($brand_id);

        // Kiểm tra xem nhà cung cấp có tồn tại không
        if (!$brand) {
            return redirect()->route('brands.list')->with('error', 'Thương hiệu không tồn tại');
        }

        // Xóa nhà cung cấp
        $brand->delete();
        return redirect()->route('brands.list')->with('success', 'Thương hiệu đã được xóa');
    }
}