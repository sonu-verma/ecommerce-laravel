<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of orders (admin).
     */
    public function index()
    {
        $orders = Order::with(['user', 'orderItems.product'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display user's orders.
     */
    public function myOrders()
    {
        $orders = Auth::user()->orders()
            ->with('orderItems.product')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.my-orders', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        // Check if user can view this order
        if (Auth::user()->id !== $order->user_id && !Auth::user()->is_admin) {
            abort(403);
        }

        $order->load(['user', 'orderItems.product', 'payment']);

        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified order (admin only).
     */
    public function edit(Order $order)
    {
        $order->load(['user', 'orderItems.product']);
        return view('admin.orders.edit', compact('order'));
    }

    /**
     * Update the specified order (admin only).
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'notes' => 'nullable|string|max:1000',
        ]);

        $order->update([
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order updated successfully.');
    }

    /**
     * Cancel an order (user can cancel pending orders).
     */
    public function cancel(Order $order)
    {
        if (Auth::user()->id !== $order->user_id) {
            abort(403);
        }

        if (!$order->canBeCancelled()) {
            return redirect()->back()->with('error', 'This order cannot be cancelled.');
        }

        $order->update(['status' => 'cancelled']);

        // Restore inventory
        foreach ($order->orderItems as $item) {
            $item->product->increment('stock_quantity', $item->quantity);
        }

        return redirect()->route('orders.show', $order)
            ->with('success', 'Order cancelled successfully.');
    }

    /**
     * Remove the specified order (admin only).
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully.');
    }
}
