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
            'product_name' => ['required', 'string', 'max:30', 'regex:/^[\pL\s\d\-]+$/u'],
            'product_price' => 'required|numeric|min:0|max:99999999',
            'product_qty' => 'required|integer|min:0|max:100000',
            'category_id' => 'required|exists:category,category_id',
            'brand_id' => 'nullable|exists:brand,brand_id',
            'product_description' => 'nullable|string|max:2000',
            'product_images_1' => 'required|image|mimes:jpg,jpeg,png,gif|max:4048',
            'product_images_2' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:4048',
            'product_images_3' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:4048',
        ], [
            'product_name.required' => 'Vui lòng nhập tên sản phẩm.',
            'product_name.max' => 'Tên sản phẩm không được vượt quá 30 ký tự.',
            'product_name.regex' => 'Tên sản phẩm chỉ được chứa chữ, số, khoảng trắng và dấu gạch ngang.',
            'product_price.required' => 'Vui lòng nhập giá sản phẩm.',
            'product_price.numeric' => 'Giá sản phẩm phải là số hợp lệ.',
            'product_price.min' => 'Giá sản phẩm phải lớn hơn hoặc bằng 0.',
            'product_price.max' => 'Giá sản phẩm không được vượt quá 99.999.999.',
            'product_qty.required' => 'Vui lòng nhập số lượng.',
            'product_qty.integer' => 'Số lượng phải là số nguyên.',
            'product_qty.min' => 'Số lượng phải lớn hơn hoặc bằng 0.',
            'product_qty.max' => 'Số lượng không được vượt quá 100000.',
            'category_id.required' => 'Vui lòng chọn danh mục sản phẩm.',
            'category_id.exists' => 'Danh mục sản phẩm không tồn tại.',
            'brand_id.exists' => 'Thương hiệu không tồn tại.',
            'product_description.max' => 'Mô tả sản phẩm không được vượt quá 2000 ký tự.',
            'product_images_1.required' => 'Ảnh 1 là bắt buộc.',
            'product_images_1.image' => 'File ảnh 1 không hợp lệ.',
            'product_images_1.mimes' => 'Ảnh 1 phải có định dạng jpg, jpeg, png hoặc gif.',
            'product_images_1.max' => 'Ảnh 1 không được vượt quá 4MB.',
            'product_images_2.image' => 'File ảnh 2 không hợp lệ.',
            'product_images_2.mimes' => 'Ảnh 2 phải có định dạng jpg, jpeg, png hoặc gif.',
            'product_images_2.max' => 'Ảnh 2 không được vượt quá 4MB.',
            'product_images_3.image' => 'File ảnh 3 không hợp lệ.',
            'product_images_3.mimes' => 'Ảnh 3 phải có định dạng jpg, jpeg, png hoặc gif.',
            'product_images_3.max' => 'Ảnh 3 không được vượt quá 4MB.',
        ]);

        $path = public_path('assets/images/products');

        $image1 = null;
        $image2 = null;
        $image3 = null;

        if ($request->hasFile('product_images_1')) {
            $file1 = $request->file('product_images_1');
            $image1 = time() . '_1_' . $file1->getClientOriginalName();
            $file1->move($path, $image1);
        }

        if ($request->hasFile('product_images_2')) {
            $file2 = $request->file('product_images_2');
            $image2 = time() . '_2_' . $file2->getClientOriginalName();
            $file2->move($path, $image2);
        }

        if ($request->hasFile('product_images_3')) {
            $file3 = $request->file('product_images_3');
            $image3 = time() . '_3_' . $file3->getClientOriginalName();
            $file3->move($path, $image3);
        }

        Products::create([
            'product_name' => $request->product_name,
            'product_price' => $request->product_price,
            'product_qty' => $request->product_qty,
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'product_description' => $request->product_description,
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
            'product_name' => ['required', 'string', 'max:30', 'regex:/^[\pL\s\d\-]+$/u'],
            'product_price' => 'required|numeric|min:0|max:99999999',
            'product_qty' => 'required|integer|min:0|max:100000',
            'category_id' => 'required|exists:category,category_id',
            'brand_id' => 'nullable|exists:brand,brand_id',
            'product_description' => 'nullable|string|max:2000',
            'product_images_1' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'product_images_2' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'product_images_3' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ], [
            'product_name.required' => 'Vui lòng nhập tên sản phẩm.',
            'product_name.max' => 'Tên sản phẩm không được vượt quá 30 ký tự.',
            'product_name.regex' => 'Tên sản phẩm chỉ được chứa chữ, số, khoảng trắng và dấu gạch ngang.',
            'product_price.required' => 'Vui lòng nhập giá sản phẩm.',
            'product_price.numeric' => 'Giá sản phẩm phải là số hợp lệ.',
            'product_price.min' => 'Giá sản phẩm phải lớn hơn hoặc bằng 0.',
            'product_price.max' => 'Giá sản phẩm không được vượt quá 99.999.999.',
            'product_qty.required' => 'Vui lòng nhập số lượng.',
            'product_qty.integer' => 'Số lượng phải là số nguyên.',
            'product_qty.min' => 'Số lượng phải lớn hơn hoặc bằng 0.',
            'product_qty.max' => 'Số lượng không được vượt quá 100000.',
            'category_id.required' => 'Vui lòng chọn danh mục sản phẩm.',
            'category_id.exists' => 'Danh mục sản phẩm không tồn tại.',
            'brand_id.exists' => 'Thương hiệu không tồn tại.',
            'product_description.max' => 'Mô tả sản phẩm không được vượt quá 2000 ký tự.',
            'product_images_1.image' => 'File ảnh 1 không hợp lệ.',
            'product_images_1.mimes' => 'Ảnh 1 phải có định dạng jpg, jpeg, png hoặc gif.',
            'product_images_1.max' => 'Ảnh 1 không được vượt quá 2MB.',
            'product_images_2.image' => 'File ảnh 2 không hợp lệ.',
            'product_images_2.mimes' => 'Ảnh 2 phải có định dạng jpg, jpeg, png hoặc gif.',
            'product_images_2.max' => 'Ảnh 2 không được vượt quá 2MB.',
            'product_images_3.image' => 'File ảnh 3 không hợp lệ.',
            'product_images_3.mimes' => 'Ảnh 3 phải có định dạng jpg, jpeg, png hoặc gif.',
            'product_images_3.max' => 'Ảnh 3 không được vượt quá 2MB.',
        ]);

        $path = public_path('assets/images/products');

        // Xử lý ảnh nếu có upload mới, xóa ảnh cũ
        if ($request->hasFile('product_images_1')) {
            if ($product->product_images_1 && file_exists($path . '/' . $product->product_images_1)) {
                unlink($path . '/' . $product->product_images_1);
            }
            $file1 = $request->file('product_images_1');
            $product->product_images_1 = time() . '_1_' . $file1->getClientOriginalName();
            $file1->move($path, $product->product_images_1);
        }

        if ($request->hasFile('product_images_2')) {
            if ($product->product_images_2 && file_exists($path . '/' . $product->product_images_2)) {
                unlink($path . '/' . $product->product_images_2);
            }
            $file2 = $request->file('product_images_2');
            $product->product_images_2 = time() . '_2_' . $file2->getClientOriginalName();
            $file2->move($path, $product->product_images_2);
        }

        if ($request->hasFile('product_images_3')) {
            if ($product->product_images_3 && file_exists($path . '/' . $product->product_images_3)) {
                unlink($path . '/' . $product->product_images_3);
            }
            $file3 = $request->file('product_images_3');
            $product->product_images_3 = time() . '_3_' . $file3->getClientOriginalName();
            $file3->move($path, $product->product_images_3);
        }

        $product->product_name = $request->product_name;
        $product->product_price = $request->product_price;
        $product->product_qty = $request->product_qty;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->product_description = $request->product_description;

        $product->save();

        return redirect()->route('products.list')->with('success', 'Sản phẩm đã được cập nhật thành công');
    }

    /**
     * Xóa sản phẩm
     */
    public function deleteProduct($product_id)
    {
        $product = Products::find($product_id);

        if (!$product) {
            return redirect()->route('products.list')->with('error', 'Sản phẩm không tồn tại hoặc đã bị xóa trước đó.');
        }

        $path = public_path('assets/images/products');

        // Xóa ảnh khỏi thư mục
        /*
        if ($product->product_images_1 && file_exists($path . '/' . $product->product_images_1)) {
            unlink($path . '/' . $product->product_images_1);
        }
        if ($product->product_images_2 && file_exists($path . '/' . $product->product_images_2)) {
            unlink($path . '/' . $product->product_images_2);
        }
        if ($product->product_images_3 && file_exists($path . '/' . $product->product_images_3)) {
            unlink($path . '/' . $product->product_images_3);
        }
        */

        $product->delete();

        return redirect()->route('products.list')->with('success', 'Sản phẩm đã được xóa thành công');
    }
    public function readProduct($product_id)
    {
        $product = Products::with('category')->find($product_id);
        if (!$product) {
            return redirect()->route('products.list')
                ->with('error', 'Sản phẩm đã bị xóa hoặc không tồn tại.');
        }
        return view('crud_product.read', compact('product'));
    }
}
