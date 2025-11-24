<?php

namespace App\Http\Controllers;

use App\Models\FixedAsset;
use Illuminate\Http\Request;

class FixedAssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assets = FixedAsset::paginate(10);
        return view('fixed_assets.index', compact('assets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('fixed_assets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'asset_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'asset_number' => 'nullable|string|unique:fixed_assets,asset_number',
            'acquisition_date' => 'required|date',
            'cost' => 'required|numeric|min:0',
            'salvage_value' => 'nullable|numeric|min:0',
            'useful_life_years' => 'required|integer|min:1',
            'depreciation_method' => 'required|string|max:255',
            'current_value' => 'required|numeric|min:0',
            'disposal_date' => 'nullable|date',
        ]);

        FixedAsset::create($request->all());

        return redirect()->route('finance.fixed-assets.index')->with('success', 'Fixed Asset created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(FixedAsset $fixedAsset)
    {
        return view('fixed_assets.show', compact('fixedAsset'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FixedAsset $fixedAsset)
    {
        return view('fixed_assets.edit', compact('fixedAsset'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FixedAsset $fixedAsset)
    {
        $request->validate([
            'asset_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'asset_number' => 'nullable|string|unique:fixed_assets,asset_number,' . $fixedAsset->id,
            'acquisition_date' => 'required|date',
            'cost' => 'required|numeric|min:0',
            'salvage_value' => 'nullable|numeric|min:0',
            'useful_life_years' => 'required|integer|min:1',
            'depreciation_method' => 'required|string|max:255',
            'current_value' => 'required|numeric|min:0',
            'disposal_date' => 'nullable|date',
        ]);

        $fixedAsset->update($request->all());

        return redirect()->route('finance.fixed-assets.index')->with('success', 'Fixed Asset updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FixedAsset $fixedAsset)
    {
        $fixedAsset->delete();

        return redirect()->route('finance.fixed-assets.index')->with('success', 'Fixed Asset deleted successfully.');
    }
}
