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
        //dd(session('coupon'));
        $request->validate([
            'fullname' => ['required', 'regex:/^[a-zA-ZÀ-ỹ\s]+$/u', 'max:255'],
            'phone'    => ['required', 'regex:/^0[0-9]{8,10}$/'],
            'address'  => ['required', 'string', 'max:500'],
        ], [
            'fullname.required' => 'Vui lòng nhập họ và tên.',
            'fullname.regex'    => 'Họ tên chỉ được chứa chữ cái và khoảng trắng.',
            'phone.required'    => 'Vui lòng nhập số điện thoại.',
            'phone.regex'       => 'Số điện thoại phải bắt đầu bằng 0 và có 9-11 chữ số.',
            'address.required'  => 'Vui lòng nhập địa chỉ.',
        ]);

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để thanh toán.');
        }

        $user   = Auth::user();
        $cart   = session('cart', []);
        $coupon = session('coupon');

        // Tính toán
        $totalQty    = collect($cart)->sum('quantity');
        $subtotal    = collect($cart)->sum(fn($item) => $item['product_price'] * $item['quantity']);
        
        $couponId = null;
        $discount = 0;

        if ($coupon) {
            if (isset($coupon['id'])) {
                $couponId = $coupon['id'];
            }

            $discount = ($coupon['loai_giam'] === 'percent')
                ? $subtotal * $coupon['gia_tri'] / 100
                : $coupon['gia_tri'];

            // Không để totalAmount âm
            if ($discount > $subtotal) $discount = $subtotal;
        }

        $totalAmount = $subtotal - $discount;

        // Tạo bill
        $bill = Bill::create([
            'user_id'        => $user->user_id,
            'total_qty'      => $totalQty,
            'total_amount'   => $totalAmount,
            'date_invoice'   => now(),
            'status'         => 'pending',
            'note'           => $request->fullname . ' | ' . $request->phone . ' | ' . $request->address,
            'phieu_giam_id'  => $couponId,
        ]);

        foreach ($cart as $item) {
            BillDetail::create([
                'bill_id'    => $bill->bill_id,
                'cart_id'    => null,
                'product_id' => $item['product_id'],
                'quantity'   => $item['quantity'],
                'price'      => $item['product_price'],
            ]);
        }

        // Lưu đơn hàng vào session để hiển thị ra giao diện order success
        session(['last_order' => [
            'fullname' => $request->fullname,
            'phone'    => $request->phone,
            'address'  => $request->address,
            'items'    => $cart,
            'coupon'   => $coupon,
            'total'    => $totalAmount,
        ]]);

        // Clear cart và coupon
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

    public function showOrder($id)
    {
        $bill = \App\Models\Bill::with(['details.product', 'coupon'])->findOrFail($id);
        return view('checkout.order_detail', compact('bill'));
    }

    public function myOrders()
    {
        $bills = \App\Models\Bill::where('user_id', Auth::id())
                    ->orderByDesc('date_invoice')
                    ->with(['details.product', 'coupon'])
                    ->get();

        return view('checkout.orders', compact('bills'));
    }
}
