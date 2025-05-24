<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\PhieuGiamGia;

class CartController extends Controller
{
    //thêm phiếu giảm giá mới
    public function addToCart(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        $product = Products::findOrFail($productId);

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'product_id'    => $product->product_id,
                'product_name'  => $product->product_name,
                'product_price' => $product->product_price,
                'product_image' => $product->product_images_1,
                'quantity'      => $quantity,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Đã thêm vào giỏ hàng!');
    }


    public function viewCart()
    {

        $cart = session()->get('cart', []);
        return view('shoping-cart', compact('cart'));
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng.');
    }
    //sửa lại phiếu giảm giá
    public function update(Request $request, $id)
    {
        $quantity = (int) $request->input('quantity');

        if ($quantity < 1) {
            return redirect()->back()->with('error', 'Số lượng phải lớn hơn hoặc bằng 1.');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $quantity;
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Cập nhật số lượng thành công.');
        }

        return redirect()->back()->with('error', 'Sản phẩm không tồn tại trong giỏ hàng.');
    }

    //áp dụng phiếu giảm giá

        public function applyCoupon(Request $request)
    {
        $maPhieu = $request->input('ma_phieu');

        $coupon = PhieuGiamGia::where('ten_phieu', $maPhieu)
            ->where('ngay_bat_dau', '<=', now())
            ->where('ngay_ket_thuc', '>=', now())
            ->first();

        if (!$coupon) {
            return redirect()->back()->with('error', 'Mã giảm giá không hợp lệ hoặc đã hết hạn.');
        }

        session([
            'coupon' => [
                'id'        => $coupon->id,                   
                'ma_phieu'  => $coupon->ten_phieu,
                'loai_giam' => 'percent',
                'gia_tri'   => $coupon->phan_tram_giam,
            ]
        ]);

        return redirect()->back()->with('success', 'Áp dụng mã giảm giá thành công!');
    }

    

    //xóa phiếu giảm giá trong cart
        public function removeCoupon()
    {
        session()->forget('coupon');
        return redirect()->back()->with('success', 'Đã hủy mã giảm giá.');
    }

}
