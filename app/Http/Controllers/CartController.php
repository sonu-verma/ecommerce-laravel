<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Display the shopping cart.
     */
    public function index()
    {
        $cart = $this->cartService->getCart();
        $cartItems = $cart->cartItems()->with('product')->get();
        $total = $cart->total;

        return view('cart.index', compact('cart', 'cartItems', 'total'));
    }

    /**
     * Add a product to the cart.
     */
    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->stock_quantity,
        ]);

        $this->cartService->addToCart($product, $request->quantity);

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    /**
     * Update cart item quantity.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0|max:' . $product->stock_quantity,
        ]);

        $this->cartService->updateCartItem($product, $request->quantity);

        return redirect()->route('cart.index')->with('success', 'Cart updated successfully!');
    }

    /**
     * Remove a product from the cart.
     */
    public function remove(Product $product)
    {
        $this->cartService->removeFromCart($product);

        return redirect()->route('cart.index')->with('success', 'Product removed from cart!');
    }

    /**
     * Clear the entire cart.
     */
    public function clear()
    {
        $this->cartService->clearCart();
        return redirect()->route('cart.index')->with('success', 'Cart cleared successfully!');
    }

    /**
     * Get cart count for navigation.
     */
    public function getCartCount()
    {
        return $this->cartService->getCartItemCount();
    }
}
