<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Bill;
use App\Models\BillDetail;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        $coupon = session('coupon');

        return view('checkout.index', compact('cart', 'coupon'));
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'fullname' => 'required|string|max:255',
            'phone'    => 'required|string|max:20',
            'address'  => 'required|string|max:500',
        ]);

        $cart = session('cart', []);
        $coupon = session('coupon');
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để thanh toán.');
        }
        $user = Auth::user();

        // Tính toán
        $totalQty    = collect($cart)->sum('quantity');
        $totalAmount = collect($cart)->sum(fn($item) => $item['product_price'] * $item['quantity']);

        $couponId = null;
        if ($coupon && isset($coupon['id'])) {
            $couponId = $coupon['id']; // lưu ID
            $giam = ($coupon['loai_giam'] == 'percent')
                ? $totalAmount * $coupon['gia_tri'] / 100
                : $coupon['gia_tri'];
            $totalAmount -= $giam;
        }
        // Tạo bill
        $bill = Bill::create([
            'user_id' => $user->user_id,
            'total_qty'     => $totalQty,
            'total_amount'  => $totalAmount,
            'date_invoice'  => now(),
            'status'        => 'pending',
            'note'          => $request->fullname . ' | ' . $request->phone . ' | ' . $request->address,
            'phieu_giam_id' => $couponId,
        ]);

        // ✅ Lưu chi tiết đơn hàng đúng cách
        foreach ($cart as $item) {
            BillDetail::create([
                'bill_id'    => $bill->bill_id, // hoặc $bill->id nếu primary key là id
                'cart_id'    => null,
                'product_id' => $item['product_id'],
                'quantity'   => $item['quantity'],
                'price'      => $item['product_price'],
            ]);
        }

        // Lưu đơn hàng gần nhất để hiển thị cho người dùng
        session(['last_order' => [
            'fullname' => $request->fullname,
            'phone'    => $request->phone,
            'address'  => $request->address,
            'items'    => $cart,
            'coupon'   => $coupon,
            'total'    => $totalAmount,
        ]]);

        // Xóa giỏ hàng và mã giảm giá khỏi session
        session()->forget('cart');
        session()->forget('coupon');

        return redirect()->route('order.success');
    }
    public function success()
    {
        $order = session('last_order');
        
        if (!$order) {
            return redirect('/'); // nếu không có order thì quay lại trang chủ
        }

        return view('checkout.success', compact('order'));
    }
}
