<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\PhieuGiamGia;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = (int) $request->input('quantity', 1);

        $product = Products::findOrFail($productId);

        $cart = session()->get('cart', []);

        $currentQuantity = isset($cart[$productId]) ? $cart[$productId]['quantity'] : 0;
        $newQuantity = $currentQuantity + $quantity;

        if ($product->product_qty <= $currentQuantity) {
            return redirect()->back()->with('error', 'Bạn đã thêm tối đa số lượng có sẵn (' . $product->product_qty . ' sản phẩm).');
        }

        if ($newQuantity > $product->product_qty) {
            $remaining = max(0, $product->product_qty - $currentQuantity);
            return redirect()->back()->with('error', 'Số lượng vượt quá tồn kho. Chỉ còn ' . $remaining . ' sản phẩm.');
        }

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $newQuantity;
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

    public function update(Request $request, $id)
    {
        $quantity = (int) $request->input('quantity');

        if ($quantity < 1) {
            return redirect()->back()->with('error', 'Số lượng phải lớn hơn hoặc bằng 1.');
        }

        $product = Products::findOrFail($id);

        if ($quantity > $product->product_qty) {
            return redirect()->back()->with('error', 'Số lượng vượt quá tồn kho. Chỉ còn ' . $product->product_qty . ' sản phẩm.');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $quantity;
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Cập nhật số lượng thành công.');
        }

        return redirect()->back()->with('error', 'Sản phẩm không tồn tại trong giỏ hàng.');
    }

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

    public function removeCoupon()
    {
        session()->forget('coupon');
        return redirect()->back()->with('success', 'Đã hủy mã giảm giá.');
    }
}
