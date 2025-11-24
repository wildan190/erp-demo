<?php

namespace App\Http\Controllers;

use App\Models\FollowUp;
use App\Models\Lead;
use App\Models\Opportunity;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;

class FollowUpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $followUps = FollowUp::with('user', 'followupable')->latest()->paginate(10);
        return view('follow-ups.index', compact('followUps'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $leads = Lead::all();
        $opportunities = Opportunity::all();
        $customers = Customer::all();
        $users = User::all();
        return view('follow-ups.create', compact('leads', 'opportunities', 'customers', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'followupable_id' => 'required|numeric',
            'followupable_type' => 'required|string',
            'type' => 'nullable|string|max:255',
            'notes' => 'required|string',
            'scheduled_date' => 'required|date',
            'is_completed' => 'boolean',
        ]);

        FollowUp::create($request->all());

        return redirect()->route('follow_ups.index')->with('success', 'Follow-up created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(FollowUp $followUp)
    {
        return view('follow-ups.show', compact('followUp'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FollowUp $followUp)
    {
        $leads = Lead::all();
        $opportunities = Opportunity::all();
        $customers = Customer::all();
        $users = User::all();
        return view('follow-ups.edit', compact('followUp', 'leads', 'opportunities', 'customers', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FollowUp $followUp)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'followupable_id' => 'required|numeric',
            'followupable_type' => 'required|string',
            'type' => 'nullable|string|max:255',
            'notes' => 'required|string',
            'scheduled_date' => 'required|date',
            'is_completed' => 'boolean',
        ]);

        $followUp->update($request->all());

        return redirect()->route('follow-ups.index')->with('success', 'Follow-up updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FollowUp $followUp)
    {
        $followUp->delete();
        return redirect()->route('follow-ups.index')->with('success', 'Follow-up deleted successfully.');
    }
}
