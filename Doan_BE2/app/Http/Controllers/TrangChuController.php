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

        if ($request->filled('search')) {
            $query->where('product_name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(8);
        $products->appends($request->only(['search', 'category_id']));

        $categories = Category::all();

        $wishlistCount = 0;
        $userWishlistIds = [];

        if (Auth::check()) {
            $wishlistCount = Wishlist::where('user_id', Auth::id())->count();
            $userWishlistIds = Wishlist::where('user_id', Auth::id())->pluck('product_id')->toArray();

            // Lưu vào session để dùng trong header (trái tim)
            session(['wishlist_count' => $wishlistCount]);
        }

        return view('index', compact('products', 'categories', 'userWishlistIds', 'wishlistCount'));
    }

    
    public function detailProduct($product_id)
    {
        $product = Products::with(['category', 'brand'])->findOrFail($product_id);

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