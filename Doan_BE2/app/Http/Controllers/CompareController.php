<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;

class CompareController extends Controller
{
    // Thêm sản phẩm vào danh sách so sánh
    public function addToCompare($product_id)
    {
            // Lấy danh sách sản phẩm đang so sánh trong session
        $compare = session()->get('compare', []);

        // Kiểm tra sản phẩm đã tồn tại trong danh sách chưa
        if (!in_array($product_id, $compare)) {
            // Giới hạn tối đa 3 sản phẩm
            if (count($compare) >= 3) {
                return back()->with('error', 'Chỉ so sánh tối đa 3 sản phẩm!');
            }

            // Thêm sản phẩm mới
            $compare[] = $product_id;
            session(['compare' => $compare]);
        } else {
            return back()->with('info', 'Sản phẩm đã có trong danh sách so sánh.');
        }

        return back()->with('success', 'Đã thêm vào danh sách so sánh!');
    }

    // Xem danh sách sản phẩm so sánh
    public function showCompare()
    {
        $compareIds = session('compare', []);
        $products = Products::whereIn('product_id', $compareIds)->get();

        // Loại bỏ các sản phẩm đã bị xóa
        $valid_ids = $products->pluck('product_id')->toArray();
        session(['compare' => $valid_ids]);

        return view('compare', compact('products'));
    }


    // Xoá sản phẩm khỏi danh sách
    public function removeFromCompare($product_id)
    {
        $compare = session('compare', []);
        $compare = array_diff($compare, [$product_id]);
        session(['compare' => $compare]);

        return back()->with('success', 'Đã xoá khỏi danh sách so sánh!');
    }

    //
}
