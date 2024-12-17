<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Plan;
use Illuminate\Http\Request;

class OrderController extends Controller
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

    public function create()
    {
        // Fetch all users and plans to associate with the order
        $users = User::all();
        $plans = Plan::all();
        return view('orders.create', compact('users', 'plans'));
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'plan_id' => 'required|exists:plans,id',
            'payment_status' => 'required|in:pending,completed,failed',
            'order_date' => 'nullable|date',
            'expiry_date' => 'nullable|date',
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

        // Create a new order with sanitized inputs
        $order = Order::create([
            'user_id' => $request->user_id,
            'plan_id' => $request->plan_id,
            'payment_status' => $request->payment_status,
            'order_date' => $request->order_date,
            'expiry_date' => $request->expiry_date,
            'delivery_method' => $request->delivery_method,
            'delivery_status' => $request->delivery_status,
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

        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    public function show(Order $order)
    {
        // Display the details of a single order
        return view('orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        // Fetch users and plans for the edit form
        $users = User::all();
        $plans = Plan::all();
        return view('orders.edit', compact('order', 'users', 'plans'));
    }

    public function update(Request $request, Order $order)
    {
        // Validate the incoming request data
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'plan_id' => 'required|exists:plans,id',
            'payment_status' => 'required|in:pending,completed,failed',
            'order_date' => 'nullable|date',
            'expiry_date' => 'nullable|date',
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

        // Update the order with sanitized inputs
        $order->update([
            'user_id' => $request->user_id,
            'plan_id' => $request->plan_id,
            'payment_status' => $request->payment_status,
            'order_date' => $request->order_date,
            'expiry_date' => $request->expiry_date,
            'delivery_method' => $request->delivery_method,
            'delivery_status' => $request->delivery_status,
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

        return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
    }

    public function destroy(Order $order)
    {
        // Delete associated payments
        $order->payment()->delete(); // Ensure you have a relationship defined in the Order model

        // Delete the order
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }
}
