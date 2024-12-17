<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PackageController extends Controller
{
    public function index()
    {

        return view('orders.index');
    }

    public function getOrders(Request $request)
    {
        $orders = Order::with(['user', 'plan'])->get();

        return datatables()->of($orders)
            ->addColumn('action', function($order) {
                // Use PHP's route() helper to generate URLs
                $editUrl = route('orders.edit', $order->id);
                $deleteUrl = route('orders.destroy', $order->id);

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



    public function details($plan_id)
    {
        $plan = Plan::findOrFail($plan_id);
        return view('packages.details', compact('plan'));
    }

    public function paymentForm($plan_id)
    {
        $plan = Plan::findOrFail($plan_id);
        $order = new Order();
        return view('packages.payment', compact('plan', 'order'));
    }

    public function store(Request $request, $plan_id)
    {
        $request->validate([
            'payment_method' => 'required|in:dummy_paypal,dummy_stripe,dummy_credit_card',
            'delivery_method' => 'required|in:by_air,by_road,by_ship',
            'flight_number' => 'nullable|string|max:255',
            'departure_date' => 'nullable|date',
            'vehicle_number' => 'nullable|string|max:255',
            'driver_name' => 'nullable|string|max:255',
            'estimated_arrival' => 'nullable|date',
            'home_delivery' => 'nullable|in:yes,no',
            'home_address' => 'nullable|string|max:255',
            'ship_name' => 'nullable|string|max:255',
            'port_of_origin' => 'nullable|string|max:255',
            'port_of_destination' => 'nullable|string|max:255',
            'by_agency' => 'nullable|in:yes,no',
            'agency_name' => 'nullable|string|max:255',
            'agency_contact' => 'nullable|string|max:255',
        ]);

        $plan = Plan::findOrFail($plan_id);

        // Create the order
        $order = Order::create([
            'user_id' => Auth::id(),
            'plan_id' => $plan_id,
            'payment_status' => 'pending',
            'order_date' => now(),
            'expiry_date' => now()->addDays($plan->duration),
            'delivery_method' => $request->delivery_method,
            'flight_number' => scriptStripper($request->flight_number),
            'departure_date' => $request->departure_date,
            'vehicle_number' => scriptStripper($request->vehicle_number),
            'driver_name' => scriptStripper($request->driver_name),
            'estimated_arrival' => $request->estimated_arrival,
            'home_delivery' => $request->home_delivery,
            'home_address' => scriptStripper($request->home_address),
            'ship_name' => scriptStripper($request->ship_name),
            'port_of_origin' => scriptStripper($request->port_of_origin),
            'port_of_destination' => scriptStripper($request->port_of_destination),
            'by_agency' => $request->by_agency,
            'agency_name' => scriptStripper($request->agency_name),
            'agency_contact' => scriptStripper($request->agency_contact),
        ]);

        // Generate a unique transaction ID
        $transaction_id = Str::uuid();

        // Create the payment record
        $payment = Payment::create([
            'order_id' => $order->id,
            'amount' => $plan->price,
            'transaction_id' => $transaction_id,
            'payment_method' => $request->payment_method,
            'payment_date' => now(),
            'status' => 'completed',
        ]);

        // Update the order payment status
        $order->payment_status = 'completed';
        $order->save();

        // Redirect to the thank-you page
        return redirect()->route('packages.thankYou', $order->id);
    }

    public function thankYou($order_id)
    {
        $order = Order::findOrFail($order_id);
        return view('packages.thankYou', compact('order'));
    }

    public function userOrders(Request $request)
    {


        return view('packages.userOrders');
    }


    public function getUserOrders(Request $request)
{
    $userId = Auth::id();

    $orders = Order::where('user_id', $userId)
                   ->with(['user', 'plan'])
                   ->get();

    return datatables()->of($orders)
        ->addColumn('action', function($order) {
            $editUrl = route('packages.edit', $order->id);
            $deleteUrl = route('orders.destroy', $order->id);

            return '<a href="' . $editUrl . '" class="text-blue-600">Edit</a> |
                    <form action="' . $deleteUrl . '" method="POST" onsubmit="return confirmDelete()" class="inline">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button type="submit" class="text-red-600">Delete</button>
                    </form>';
        })
        ->make(true);
}

public function edit(Order $order)
{
    // Fetch users and plans for the edit form
    $plans = Plan::all();
    return view('packages.update', compact('order',  'plans'));
}





    public function update(Request $request, Order $order)
{
    $validated = $request->validate([
        'delivery_method' => 'required|in:by_air,by_road,by_ship',
        'delivery_status' => 'required|in:yet_to_deliver,in_transit,delivered',
        'flight_number' => 'nullable|string|max:255',
        'departure_date' => 'nullable|date',
        'vehicle_number' => 'nullable|string|max:255',
        'driver_name' => 'nullable|string|max:255',
        'estimated_arrival' => 'nullable|date',
        'home_delivery' => 'nullable|in:yes,no',
        'home_address' => 'nullable|string|max:255',
        'ship_name' => 'nullable|string|max:255',
        'port_of_origin' => 'nullable|string|max:255',
        'port_of_destination' => 'nullable|string|max:255',
        'by_agency' => 'nullable|in:yes,no',
        'agency_name' => 'nullable|string|max:255',
        'agency_contact' => 'nullable|string|max:255',
    ]);

    $order->update($validated);

    return redirect()->route('packages.userOrders')->with('success', 'Order updated successfully.');
}

}
