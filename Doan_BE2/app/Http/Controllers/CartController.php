<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;

class CartController extends Controller
{
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

        $totalItems = collect($cart)->sum('quantity');

        if ($request->ajax()) {
            return response()->json(['success' => true, 'total' => $totalItems]);
        }

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
}
