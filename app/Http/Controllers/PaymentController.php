<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        // Fetch all payments along with their related order data
        $payments = Payment::with('order')->get();
        return view('payments.index', compact('payments'));
    }

    public function getPayments(Request $request)
    {
        $payments = Payment::with('order')->get();

        return datatables()->of($payments)
            ->addColumn('action', function($payment) {
                // Use PHP's route() helper to generate URLs
                $editUrl = route('payments.edit', $payment->id);
                $deleteUrl = route('payments.destroy', $payment->id);

                // Return the action buttons as a plain string
                return '<a href="' . $editUrl . '" class="text-blue-600">Edit</a> |
                        <form action="' . $deleteUrl . '" method="POST" onsubmit="return confirmDelete()" class="inline">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="text-red-600">Delete</button>
                        </form>';
            })
            ->make(true);
    }

    public function create()
    {
        // Fetch all orders to associate with the payment
        $orders = Order::all();
        return view('payments.create', compact('orders'));
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'amount' => 'required|numeric',
            'transaction_id' => 'nullable|string',
            'payment_method' => 'required|string',
            'status' => 'required|in:pending,completed,failed',
        ]);

        // Create a new payment record
        Payment::create([
            'order_id' => $request->order_id,
            'amount' => $request->amount,
            'transaction_id' => $request->transaction_id,
            'payment_method' => $request->payment_method,
            'status' => $request->status,
        ]);

        return redirect()->route('payments.index')->with('success', 'Payment created successfully.');
    }

    public function show(Payment $payment)
    {
        // Display the details of a single payment
        return view('payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        // Fetch all orders for the edit form
        $orders = Order::all();
        return view('payments.edit', compact('payment', 'orders'));
    }

    public function update(Request $request, Payment $payment)
    {
        // Validate the incoming request data
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'amount' => 'required|numeric',
            'transaction_id' => 'nullable|string',
            'payment_method' => 'required|string',
            'status' => 'required|in:pending,completed,failed',
        ]);

        // Update the payment record with validated data
        $payment->update([
            'order_id' => $request->order_id,
            'amount' => $request->amount,
            'transaction_id' => $request->transaction_id,
            'payment_method' => $request->payment_method,
            'status' => $request->status,
        ]);

        return redirect()->route('payments.index')->with('success', 'Payment updated successfully.');
    }

    public function destroy(Payment $payment)
    {
        // Delete the payment record
        $payment->delete();
        return redirect()->route('payments.index')->with('success', 'Payment deleted successfully.');
    }
}
