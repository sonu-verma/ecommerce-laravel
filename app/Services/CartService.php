<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartService
{
    public function getOrCreateCart(): Cart
    {
        if (Auth::check()) {
            // For authenticated users, get or create cart
            $cart = Auth::user()->activeCart;
            if (!$cart) {
                $cart = Cart::create([
                    'cart_id' => Cart::generateCartId(),
                    'user_id' => Auth::id(),
                ]);
            }
            return $cart;
        } else {
            // For guest users, get or create cart using session
            $cartId = Session::get('cart_id');
            $cart = null;

            if ($cartId) {
                $cart = Cart::where('cart_id', $cartId)->first();
            }

            if (!$cart) {
                $cart = Cart::create([
                    'cart_id' => Cart::generateCartId(),
                    'session_id' => Session::getId(),
                ]);
                Session::put('cart_id', $cart->cart_id);
            }

            return $cart;
        }
    }

    public function addToCart(Product $product, int $quantity = 1): void
    {
        $cart = $this->getOrCreateCart();
        $cart->addProduct($product, $quantity);
    }

    public function updateCartItem(Product $product, int $quantity): void
    {
        $cart = $this->getOrCreateCart();
        $cart->updateProductQuantity($product, $quantity);
    }

    public function removeFromCart(Product $product): void
    {
        $cart = $this->getOrCreateCart();
        $cart->removeProduct($product);
    }

    public function clearCart(): void
    {
        $cart = $this->getOrCreateCart();
        $cart->clear();
    }

    public function getCart(): ?Cart
    {
        return $this->getOrCreateCart();
    }

    public function getCartItemCount(): int
    {
        $cart = $this->getOrCreateCart();
        return $cart->item_count;
    }

    public function getCartTotal(): float
    {
        $cart = $this->getOrCreateCart();
        return $cart->total;
    }

    public function mergeGuestCartWithUserCart(): void
    {
        if (!Auth::check()) {
            return;
        }

        $guestCartId = Session::get('cart_id');
        if (!$guestCartId) {
            return;
        }

        $guestCart = Cart::where('cart_id', $guestCartId)->first();
        if (!$guestCart) {
            return;
        }

        $userCart = Auth::user()->activeCart;
        if (!$userCart) {
            $userCart = Cart::create([
                'cart_id' => Cart::generateCartId(),
                'user_id' => Auth::id(),
            ]);
        }

        $guestCart->mergeWithUserCart($userCart);
        Session::forget('cart_id');
    }

    public function isCartEmpty(): bool
    {
        $cart = $this->getOrCreateCart();
        return $cart->isEmpty();
    }
} 