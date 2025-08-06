<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the home page with featured products.
     */
    public function index()
    {
        $featuredProducts = Product::with('category')
            ->active()
            ->featured()
            ->take(8)
            ->get();

        $latestProducts = Product::with('category')
            ->active()
            ->latest()
            ->take(8)
            ->get();

        $categories = Category::where('is_active', true)
            ->withCount('products')
            ->take(6)
            ->get();

        return view('home', compact('featuredProducts', 'latestProducts', 'categories'));
    }

    /**
     * Show all products with filtering and search.
     */
    public function products(Request $request)
    {
        $query = Product::with('category')->active();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Price filter
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sort products
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->latest();
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::where('is_active', true)->get();

        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Show product details.
     */
    public function product(Product $product)
    {
        if (!$product->is_active) {
            abort(404);
        }

        $product->load('category');

        // Get related products
        $relatedProducts = Product::with('category')
            ->active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }

    /**
     * Show category products.
     */
    public function category(Category $category)
    {
        if (!$category->is_active) {
            abort(404);
        }

        $products = Product::with('category')
            ->active()
            ->where('category_id', $category->id)
            ->paginate(12);

        return view('categories.show', compact('category', 'products'));
    }
}
