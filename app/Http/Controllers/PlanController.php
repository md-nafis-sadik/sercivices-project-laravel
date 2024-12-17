<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Feature;
use Illuminate\Http\Request;


class PlanController extends Controller
{
    public function index()
    {
        // Eager load the 'features' relationship to avoid N+1 query problem

        return view('plans.index');
    }

    public function getPlans(Request $request)
    {
        $plans = Plan::with('features')->get();

        return datatables()->of($plans)
            ->addColumn('action', function($plan) {
                // Use PHP's route() helper to generate URLs
                $editUrl = route('plans.edit', $plan->id);
                $deleteUrl = route('plans.destroy', $plan->id);

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
        // Fetch all features to associate with the plan
        $features = Feature::all();
        return view('plans.create', compact('features'));
    }

    public function store(Request $request)
{
    // Validate the incoming request data
    $request->validate([
        'name' => 'required|string|max:100',
        'icon' => 'required|string|max:255|regex:/^bi\sbi-[a-z\-]+$/',
        'features' => 'required|array',
        'features.*.description' => 'required|string|max:200',
        'color' => 'nullable|regex:/^#[0-9A-Fa-f]{6}$/',
        'price' => 'required|numeric|min:0|max:1000000',
    ]);

    // Sanitize the inputs using the helper function
    $name = e(scriptStripper($request->name));
    $icon = e(scriptStripper($request->icon));
    $color = $request->color ? e($request->color) : null;
    $price = $request->price;

    // Create a new Plan and save it
    $plan = Plan::create([
        'name' => $name,
        'icon' => $icon,
        'color' => $color,
        'price' => $price,
    ]);

    // Add features and sanitize each feature's description
    foreach ($request->features as $feature) {
        Feature::create([
            'plan_id' => $plan->id,
            'description' => e(scriptStripper($feature['description'])),
        ]);
    }

    return redirect()->route('plans.index')->with('success', 'Plan and Features created successfully.');
}


    public function show(Plan $plan)
    {
        // Display the details of a single plan with its features
        return view('plans.show', compact('plan'));
    }



    public function edit(Plan $plan)
    {
        // Pass the plan and its features for editing
        return view('plans.edit', compact('plan'));
    }

    public function update(Request $request, Plan $plan)
{
    // Validate the incoming request data
    $request->validate([
        'name' => 'required|string|max:100',
        'icon' => 'required|string|max:255|regex:/^bi\sbi-[a-z\-]+$/',
        'features' => 'required|array',
        'features.*.description' => 'required|string|max:200',
        'color' => 'nullable|regex:/^#[0-9A-Fa-f]{6}$/',
        'price' => 'required|numeric|min:0|max:1000000',
    ]);

    // Sanitize the inputs using the helper function
    $name = e(scriptStripper($request->name));
    $icon = e(scriptStripper($request->icon));
    $color = $request->color ? e($request->color) : null;
    $price = $request->price;

    // Update the plan with sanitized data
    $plan->update([
        'name' => $name,
        'icon' => $icon,
        'color' => $color,
        'price' => $price,
    ]);

    // Delete existing features and re-add them with sanitized descriptions
    $plan->features()->delete();
    foreach ($request->features as $feature) {
        Feature::create([
            'plan_id' => $plan->id,
            'description' => e(scriptStripper($feature['description'])),
        ]);
    }

    return redirect()->route('plans.index')->with('success', 'Plan and Features updated successfully.');
}

    public function destroy(Plan $plan)
    {
        // Delete the plan and associated features
        $plan->delete();
        return redirect()->route('plans.index')->with('success', 'Plan deleted successfully.');
    }
}















