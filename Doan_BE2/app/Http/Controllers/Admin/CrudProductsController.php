<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Products;
use App\Models\Category;
use App\Models\Brand;

class CrudProductsController extends Controller
{
    /**
     * Hiển thị danh sách sản phẩm Admin
     */
    public function listProduct(Request $request)
    {
        $query = Products::with(['category', 'brand']);

        if ($search = $request->input('search')) {
            $query->where('product_name', 'like', "%$search%");
        }

        $products = $query->paginate(5)->appends($request->only('search'));

        return view('crud_product.list', compact('products'));
    }
    /**
     * Hiển thị form tạo sản phẩm
     */
    public function createProduct()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('crud_product.create', compact('categories', 'brands'));
    }

    /**
     * Xử lý form tạo sản phẩm
     */
    public function postProduct(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'product_price' => 'required|numeric|min:0',
            'product_qty' => 'required|integer|min:0',
            'category_id' => 'required|exists:category,category_id',
            'brand_id' => 'nullable|integer',
            'product_description' => 'nullable|string',
            'products_status' => 'nullable|boolean',
            'product_images_1' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'product_images_2' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'product_images_3' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Đường dẫn đích
        $path = public_path('assets/images/products');

        // Lưu từng ảnh
        $image1 = null;
        $image2 = null;
        $image3 = null;

        if ($request->hasFile('product_images_1')) {
            $file1 = $request->file('product_images_1');
            $image1 = $file1->getClientOriginalName();
            $file1->move($path, $image1);
        }

        if ($request->hasFile('product_images_2')) {
            $file2 = $request->file('product_images_2');
            $image2 = $file2->getClientOriginalName();
            $file2->move($path, $image2);
        }

        if ($request->hasFile('product_images_3')) {
            $file3 = $request->file('product_images_3');
            $image3 = $file3->getClientOriginalName();
            $file3->move($path, $image3);
        }

        // Lưu vào DB
        Products::create([
            'product_name' => $request->product_name,
            'product_price' => $request->product_price,
            'product_qty' => $request->product_qty,
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'product_description' => $request->product_description,
            'products_status' => $request->products_status ?? 1,
            'product_images_1' => $image1,
            'product_images_2' => $image2,
            'product_images_3' => $image3,
        ]);

        return redirect()->route('products.list')->with('success', 'Sản phẩm đã được thêm thành công');
    }


    /**
     * Hiển thị form cập nhật sản phẩm
     */
    public function updateProduct($product_id)
    {
        $product = Products::find($product_id);
        if (!$product) {
            return redirect()->route('products.list')
                ->with('error', 'Sản phẩm đã bị xóa hoặc không còn tồn tại.');
        }

        $categories = Category::all();
        $brands = Brand::all();
        return view('crud_product.update', compact('product', 'categories', 'brands'));
    }

    /**
     * Xử lý form cập nhật sản phẩm
     */
    public function postUpdateProduct(Request $request, $product_id)
    {
        $product = Products::find($product_id);

        if (!$product) {
            return redirect()->route('products.list')
                ->with('error', 'Sản phẩm đã bị xóa. Vui lòng tải lại trang.');
        }

        $request->validate([
            'product_name' => 'required|string|max:255',
            'product_price' => 'required|numeric|min:0',
            'product_qty' => 'required|integer|min:0',
            'category_id' => 'required|exists:category,category_id',
            'brand_id' => 'nullable|integer',
            'product_description' => 'nullable|string',
            'products_status' => 'nullable|boolean',
            'product_images_1' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'product_images_2' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'product_images_3' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $product = Products::findOrFail($product_id);

        // Đường dẫn đến thư mục lưu ảnh
        $path = public_path('assets/images/products');

        // Cập nhật từng ảnh nếu có file mới
        foreach ([1, 2, 3] as $i) {
            $field = "product_images_$i";
            if ($request->hasFile($field)) {
                // Xóa ảnh cũ nếu tồn tại
                $oldImage = $product->$field;
                if ($oldImage && file_exists($path . '/' . $oldImage)) {
                    unlink($path . '/' . $oldImage);
                }

                // Lưu ảnh mới
                $file = $request->file($field);
                $fileName = $file->getClientOriginalName();
                $file->move($path, $fileName);
                $product->$field = $fileName;
            }
        }

        // Cập nhật dữ liệu còn lại
        $product->update([
            'product_name' => $request->product_name,
            'product_price' => $request->product_price,
            'product_qty' => $request->product_qty,
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'product_description' => $request->product_description,
            'products_status' => $request->products_status ?? 1,
            'product_images_1' => $product->product_images_1,
            'product_images_2' => $product->product_images_2,
            'product_images_3' => $product->product_images_3,
        ]);

        return redirect()->route('products.list')->with('success', 'Cập nhật sản phẩm thành công');
    }


    /**
     * Xem chi tiết sản phẩm
     */
    public function readProduct($product_id)
    {
        $product = Products::with('category')->find($product_id);
        if (!$product) {
            return redirect()->route('products.list')
                ->with('error', 'Sản phẩm đã bị xóa hoặc không còn tồn tại. Vui lòng tải lại trang.');
        }
        return view('crud_product.read', compact('product'));
    }


    /**
     * Xóa sản phẩm
     */
    public function deleteCategory($category_id)
    {
        $category = Category::findOrFail($category_id);

        // Xóa toàn bộ sản phẩm thuộc danh mục
        $category->products()->delete();

        // Xóa danh mục
        $category->delete();

        return redirect()->route('categories.list')->with('success', 'Danh mục và các sản phẩm đã được xóa');
    }

    /**
     * Xóa sản phẩm
     */
    public function deleteProduct($product_id)
    {
        $product = Products::find($product_id);

        if (!$product) {
            return redirect()->route('products.list')
                ->with('error', 'Sản phẩm không còn tồn tại. Vui lòng tải lại trang.');
        }

        // Xóa ảnh nếu có
        foreach ([1, 2, 3] as $i) {
            $field = "product_images_$i";
            if ($product->$field) {
                Storage::disk('public')->delete($product->$field);
            }
        }

        $product->delete();

        return redirect()->route('products.list')->with('success', 'Xóa sản phẩm thành công');
    }
}
