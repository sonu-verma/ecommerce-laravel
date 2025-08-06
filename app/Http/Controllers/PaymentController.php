<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Show payment form for an order.
     */
    public function show(Order $order)
    {
        if (Auth::user()->id !== $order->user_id) {
            abort(403);
        }

        if ($order->isPaid()) {
            return redirect()->route('orders.show', $order)
                ->with('info', 'This order has already been paid.');
        }

        return view('payments.show', compact('order'));
    }

    /**
     * Process payment for an order.
     */
    public function process(Request $request, Order $order)
    {
        if (Auth::user()->id !== $order->user_id) {
            abort(403);
        }

        if ($order->isPaid()) {
            return redirect()->route('orders.show', $order)
                ->with('info', 'This order has already been paid.');
        }

        $request->validate([
            'payment_method' => 'required|in:credit_card,paypal,cash_on_delivery',
            'card_number' => 'required_if:payment_method,credit_card|string|max:19',
            'expiry_month' => 'required_if:payment_method,credit_card|integer|between:1,12',
            'expiry_year' => 'required_if:payment_method,credit_card|integer|min:' . date('Y'),
            'cvv' => 'required_if:payment_method,credit_card|string|size:3',
        ]);

        try {
            DB::beginTransaction();

            // Create payment record
            $payment = Payment::create([
                'order_id' => $order->id,
                'payment_method' => $request->payment_method,
                'amount' => $order->total,
                'status' => 'pending',
                'payment_details' => [
                    'card_number' => $request->payment_method === 'credit_card' ? substr($request->card_number, -4) : null,
                    'payment_method' => $request->payment_method,
                ],
            ]);

            // Simulate payment processing
            if ($request->payment_method === 'credit_card') {
                // In a real application, you would integrate with a payment gateway here
                $payment->markAsCompleted('TXN_' . uniqid());
                $order->update(['status' => 'processing']);
            } elseif ($request->payment_method === 'paypal') {
                // Redirect to PayPal or handle PayPal integration
                $payment->markAsCompleted('PAYPAL_' . uniqid());
                $order->update(['status' => 'processing']);
            } else {
                // Cash on delivery
                $payment->update(['status' => 'pending']);
                $order->update(['status' => 'processing']);
            }

            DB::commit();

            return redirect()->route('orders.show', $order)
                ->with('success', 'Payment processed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Payment failed: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show payment history (admin).
     */
    public function index()
    {
        $payments = Payment::with(['order.user'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.payments.index', compact('payments'));
    }

    /**
     * Show payment details (admin).
     */
    public function showPayment(Payment $payment)
    {
        $payment->load(['order.user']);
        return view('admin.payments.show', compact('payment'));
    }
}
