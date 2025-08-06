<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Show the checkout form.
     */
    public function index()
    {
        if ($this->cartService->isCartEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        $cart = $this->cartService->getCart();
        $cartItems = $cart->cartItems()->with('product')->get();
        $subtotal = $cart->total;
        $tax = $subtotal * 0.1; // 10% tax
        $shipping = 10.00; // Fixed shipping cost
        $total = $subtotal + $tax + $shipping;

        return view('checkout.index', compact('cart', 'cartItems', 'subtotal', 'tax', 'shipping', 'total'));
    }

    /**
     * Process the checkout and create order.
     */
    public function store(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string|max:500',
            'billing_address' => 'required|string|max:500',
            'phone' => 'required|string|max:20',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($this->cartService->isCartEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        try {
            DB::beginTransaction();

            $cart = $this->cartService->getCart();
            $cartItems = $cart->cartItems()->with('product')->get();

            // Validate stock availability
            foreach ($cartItems as $item) {
                if (!$item->product->isInStock() || $item->product->stock_quantity < $item->quantity) {
                    throw new \Exception("Product {$item->product->name} is not available in requested quantity.");
                }
            }

            $subtotal = $cart->total;
            $tax = $subtotal * 0.1; // 10% tax
            $shipping = 10.00; // Fixed shipping cost
            $total = $subtotal + $tax + $shipping;

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => Order::generateOrderNumber(),
                'status' => 'pending',
                'subtotal' => $subtotal,
                'tax' => $tax,
                'shipping_cost' => $shipping,
                'total' => $total,
                'shipping_address' => $request->shipping_address,
                'billing_address' => $request->billing_address,
                'phone' => $request->phone,
                'notes' => $request->notes,
            ]);

            // Create order items and update inventory
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'product_sku' => $item->product->sku,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'total_price' => $item->subtotal,
                ]);

                // Update product inventory
                $item->product->decrement('stock_quantity', $item->quantity);
            }

            // Clear cart
            $this->cartService->clearCart();

            DB::commit();

            return redirect()->route('orders.show', $order)
                ->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Checkout failed: ' . $e->getMessage())
                ->withInput();
        }
    }
}
