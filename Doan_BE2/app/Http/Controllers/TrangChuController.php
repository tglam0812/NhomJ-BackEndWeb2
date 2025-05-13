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

class TrangChuController extends Controller
{
    public function home()
    {
        $categories = Category::all();
        $products = Products::with(['category', 'brand'])
            ->orderBy('created_at', 'desc')
            ->take(8) // chỉ 8 sản phẩm
            ->get();

            $userWishlistIds = [];
            if (Auth::check()) {
                $userWishlistIds = Wishlist::where('user_id', Auth::id())->pluck('product_id')->toArray();
            }

        return view('index', compact('products', 'categories', 'userWishlistIds'));
    }
    
    public function listProductIndex(Request $request)
    {
        $query = Products::with(['category', 'brand']);
        if ($search = $request->input('search')) {
            $query->where('product_name', 'like', "%$search%");
        }
        // Lọc theo danh mục nếu có
        if ($category_id = $request->input('category_id')) {
            $query->where('category_id', $category_id);
        }
        // Lấy tất cả sản phẩm mà không phân trang
        $products = $query->orderBy('created_at', 'desc')->get();

        $categories = Category::all();

        $userWishlistIds = [];
            if (Auth::check()) {
                $userWishlistIds = Wishlist::where('user_id', Auth::id())->pluck('product_id')->toArray();
            }

        return view('index', compact('products', 'categories', 'userWishlistIds')); 
    }
    public function detailProduct($product_id)
    {
        $product = Products::with(['category', 'brand'])->findOrFail($product_id);

        return view('detail-products', compact('product'));
    }
    
}