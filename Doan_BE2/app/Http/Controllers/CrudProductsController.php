<?php

namespace App\Http\Controllers;

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
        $query = Products::with('category');

        if ($search = $request->input('search')) {
            $query->where('product_name', 'like', "%$search%");
        }

        $products = $query->paginate(10);
        return view('crud_product.list', compact('products'));
        
    }
    /**
     * Hiển thị form tạo sản phẩm
     */
    public function createProduct()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('crud_product.create', compact('categories','brands'));
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

        $image1 = $request->file('product_images_1')?->store('products', 'public');
        $image2 = $request->file('product_images_2')?->store('products', 'public');
        $image3 = $request->file('product_images_3')?->store('products', 'public');

        Products::create([
            'product_name' => $request->product_name,
            'product_price' => $request->product_price,
            'product_qty' => $request->product_qty,
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'product_description' => $request->products_description,
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
        $product = Products::findOrFail($product_id);
        $categories = Category::all();
        $brands = Brand::all();
        return view('crud_product.update', compact('product', 'categories', 'brands'));
    }

    /**
     * Xử lý form cập nhật sản phẩm
     */
    public function postUpdateProduct(Request $request, $product_id)
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

        $product = Products::findOrFail($product_id);

        foreach ([1, 2, 3] as $i) {
            $field = "product_images_$i";
            if ($request->hasFile($field)) {
                if ($product->$field) {
                    Storage::disk('public')->delete($product->$field);
                }
                $product->$field = $request->file($field)->store('products', 'public');
            }
        }

        $product->update([
            'product_name' => $request->product_name,
            'product_price' => $request->product_price,
            'product_qty' => $request->product_qty,
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'products_description' => $request->products_description,
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
        $product = Products::with('category')->findOrFail($product_id);
        return view('crud_product.read', compact('product'));
    }

    /**
     * Xóa sản phẩm
     */
    public function deleteProduct($product_id)
    {
        $product = Products::findOrFail($product_id);

        foreach ([1, 2, 3] as $i) {
            $field = "product_images_$i";
            if ($product->$field) {
                Storage::disk('public')->delete($product->$field);
            }
        }

        $product->delete();
        return redirect()->route('products.list')->with('success', 'Sản phẩm đã được xóa');
    }
}
