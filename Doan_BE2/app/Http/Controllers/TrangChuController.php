<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Products;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Wishlist;
use App\Models\Review;

class TrangChuController extends Controller
{
    public function home(Request $request)
    {
        $query = Products::with(['category', 'brand']);

        // Tìm kiếm theo tên
        if ($request->filled('search')) {
            $query->where('product_name', 'like', '%' . $request->search . '%');
        }

        // Lọc theo danh mục
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // ✅ Lọc theo giá
        if ($request->filled('price_range')) {
            switch ($request->price_range) {
                case 'under_5m':
                    $query->where('product_price', '<', 5000000);
                    break;
                case '5m_15m':
                    $query->whereBetween('product_price', [5000000, 15000000]);
                    break;
                case '15m_25m':
                    $query->whereBetween('product_price', [15000000, 25000000]);
                    break;
                case 'above_25m':
                    $query->where('product_price', '>', 25000000);
                    break;
            }
        }

        // Phân trang
        $products = $query->orderBy('created_at', 'desc')->paginate(8);
        $products->appends($request->only(['search', 'category_id', 'price_range']));

        $categories = Category::all();

        // Danh sách sản phẩm yêu thích
        $wishlistCount = 0;
        $userWishlistIds = [];

        if (Auth::check()) {
            $wishlistCount = Wishlist::where('user_id', Auth::id())->count();
            $userWishlistIds = Wishlist::where('user_id', Auth::id())->pluck('product_id')->toArray();
            session(['wishlist_count' => $wishlistCount]);
        }

        return view('index', compact('products', 'categories', 'userWishlistIds', 'wishlistCount'));
    }


    public function detailProduct($product_id)
    {
        $product = Products::with(['category', 'brand'])->find($product_id);

        if (!$product) {
            $user_id = Auth::id();
            Wishlist::where('user_id', $user_id)    
                    ->where('product_id', $product_id)
                    ->delete();
            $count = Wishlist::where('user_id', Auth::id())->count();
            session(['wishlist_count' => $count]);
            return redirect()->route('home')->with('error', 'Sản phẩm không tồn tại hoặc đã bị xóa.');
        }

        $reviews = Review::select('review_id', 'user_id', 'product_id', 'rating', 'comment', 'created_at')
            ->where('product_id', $product_id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('detail-products', compact('product', 'reviews'));
    }

    public function contact()
    {
        return view('contact');
    }

    public function about()
    {
        return view('about');
    }
}
