<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::with('product')->where('user_id', Auth::id())->get();
        return view('wishlist', compact('wishlists'));
    }

    public function toggle($product_id)
    {
        $user_id = Auth::id();

        // Lấy bản ghi wishlist nếu có
        $wishlist = Wishlist::where('user_id', $user_id)
            ->where('product_id', $product_id)
            ->first();

        if ($wishlist) {
            // Nếu đã tồn tại thì xóa
            $wishlist->delete();
            return back()->with('success', 'Đã xóa khỏi danh sách yêu thích.');
        }

        // Nếu chưa có thì thêm mới
        Wishlist::create([
            'user_id' => $user_id,
            'product_id' => $product_id
        ]);

        return back()->with('success', 'Đã thêm vào ưa thích');
    }
}
