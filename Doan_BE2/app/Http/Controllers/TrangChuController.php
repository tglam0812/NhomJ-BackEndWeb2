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
        // Khởi tạo query sản phẩm kèm quan hệ category và brand
        $query = Products::with(['category', 'brand']);

        // Lọc theo từ khóa tìm kiếm
        if ($request->filled('search')) {
            $query->where('product_name', 'like', '%' . $request->search . '%');
        }

        // Lọc theo category_id nếu có
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Phân trang sau khi lọc
        $products = $query->orderBy('created_at', 'desc')->paginate(8);

        // Giữ lại các tham số khi bấm phân trang
        $products->appends($request->only(['search', 'category_id']));

        $categories = Category::all();

        $userWishlistIds = Auth::check()
            ? Wishlist::where('user_id', Auth::id())->pluck('product_id')->toArray()
            : [];

        return view('index', compact('products', 'categories', 'userWishlistIds'));
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