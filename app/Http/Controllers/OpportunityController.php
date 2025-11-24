<?php

namespace App\Http\Controllers;

use App\Models\Opportunity;
use App\Models\Customer;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\Request;

class OpportunityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $opportunities = Opportunity::with('customer', 'lead', 'user')->latest()->paginate(10);
        return view('opportunities.index', compact('opportunities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::all();
        $leads = Lead::all();
        $users = User::all();
        return view('opportunities.create', compact('customers', 'leads', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'customer_id' => 'nullable|exists:customers,id',
            'lead_id' => 'nullable|exists:leads,id',
            'user_id' => 'nullable|exists:users,id',
            'expected_revenue' => 'nullable|numeric|min:0',
            'close_date' => 'nullable|date',
            'stage' => 'required|string|max:255',
            'probability' => 'nullable|numeric|min:0|max:1',
            'notes' => 'nullable|string',
        ]);

        Opportunity::create($request->all());

        return redirect()->route('opportunities.index')->with('success', 'Opportunity created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Opportunity $opportunity)
    {
        return view('opportunities.show', compact('opportunity'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Opportunity $opportunity)
    {
        $customers = Customer::all();
        $leads = Lead::all();
        $users = User::all();
        return view('opportunities.edit', compact('opportunity', 'customers', 'leads', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Opportunity $opportunity)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'customer_id' => 'nullable|exists:customers,id',
            'lead_id' => 'nullable|exists:leads,id',
            'user_id' => 'nullable|exists:users,id',
            'expected_revenue' => 'nullable|numeric|min:0',
            'close_date' => 'nullable|date',
            'stage' => 'required|string|max:255',
            'probability' => 'nullable|numeric|min:0|max:1',
            'notes' => 'nullable|string',
        ]);

        $opportunity->update($request->all());

        return redirect()->route('opportunities.index')->with('success', 'Opportunity updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Opportunity $opportunity)
    {
        $opportunity->delete();
        return redirect()->route('opportunities.index')->with('success', 'Opportunity deleted successfully.');
    }
}
