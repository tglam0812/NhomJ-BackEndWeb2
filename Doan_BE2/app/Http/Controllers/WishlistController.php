<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Wishlist;

class WishlistController extends Controller
{
    // Danh sách sản phẩm yêu thích
    public function index()
    {
        $wishlists = Wishlist::with('product')
            ->where('user_id', Auth::id())
            ->get();

        return view('wishlist', compact('wishlists'));
    }

    // Thêm hoặc xóa sản phẩm khỏi danh sách yêu thích
    public function toggle($product_id)
    {
        $user_id = Auth::id();

        $wishlist = Wishlist::where('user_id', $user_id)
            ->where('product_id', $product_id)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            $this->updateWishlistCountSession();
            return back()->with('success', 'Đã xóa khỏi danh sách yêu thích.');
        }

        Wishlist::create([
            'user_id' => $user_id,
            'product_id' => $product_id
        ]);

        $this->updateWishlistCountSession();
        return back()->with('success', 'Đã thêm sản phẩm vào mục yêu thích.');
    }

    // Hàm cập nhật số lượng wishlist vào session
    private function updateWishlistCountSession()
    {
        $count = Wishlist::where('user_id', Auth::id())->count();
        session(['wishlist_count' => $count]);
    }
}
