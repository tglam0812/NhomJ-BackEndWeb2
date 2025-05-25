<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Wishlist;
use App\Models\Products;

class WishlistController extends Controller
{
    // Danh sách sản phẩm yêu thích
    public function index()
    {
        $user_id = Auth::id();

        Wishlist::where('user_id', $user_id)
            ->whereDoesntHave('product')
            ->delete();

        $wishlists = Wishlist::with('product')
            ->where('user_id', $user_id)
            ->get();
            
        $this->updateWishlistCountSession();
        return view('wishlist', compact('wishlists'));
    }


    // Thêm hoặc xóa sản phẩm khỏi danh sách yêu thích
    public function toggle($product_id)
    {
        $user_id = Auth::id();

        $product = Products::find($product_id);
        if (!$product) {
            Wishlist::where('user_id', $user_id)
                ->where('product_id', $product_id)
                ->delete();

            $this->updateWishlistCountSession();

            if (request()->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Sản phẩm không tồn tại hoặc đã bị xóa.'
                ], 404);
            }

            return back()->with('error', 'Sản phẩm không tồn tại hoặc đã bị xóa.');
        }
        $wishlist = Wishlist::where('user_id', $user_id)
            ->where('product_id', $product_id)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            $this->updateWishlistCountSession();

            if (request()->ajax()) {
                return response()->json([
                    'status' => 'removed',
                    'message' => 'Đã xóa khỏi danh sách yêu thích.'
                ]);
            }

            return back()->with('success', 'Đã xóa khỏi danh sách yêu thích.');
        }

        Wishlist::create([
            'user_id' => $user_id,
            'product_id' => $product_id
        ]);

        $this->updateWishlistCountSession();

        if (request()->ajax()) {
            return response()->json([
                'status' => 'added',
                'message' => 'Đã thêm sản phẩm vào mục yêu thích.'
            ]);
        }
        return back()->with('success', 'Đã thêm sản phẩm vào mục yêu thích.');
    }


    public function updateWishlistCountSession()
    {
        $count = Wishlist::where('user_id', Auth::id())->count();
        session(['wishlist_count' => $count]);
    }
}
