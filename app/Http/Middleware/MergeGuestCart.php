<?php

namespace App\Http\Middleware;

use App\Services\CartService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class MergeGuestCart
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Check if user just logged in and has a guest cart
        if (Auth::check() && session()->has('cart_id')) {
            $this->cartService->mergeGuestCartWithUserCart();
        }

        return $response;
    }
}
