<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Risk;
use App\Models\RiskCategory;
use Illuminate\Support\Facades\Session;

class RiskController extends Controller
{
    // Display all risks
    public function index()
    {
        if (!Session::get('is_logged_in')) {
            return redirect()->route('login');
        }
        
        $risks = Risk::with(['category', 'reporter'])->orderBy('RiskID', 'desc')->get();
        return view('risks.index', compact('risks'));
    }

    // Show create form
    public function create()
    {
        if (!Session::get('is_logged_in')) {
            return redirect()->route('login');
        }
        
        $categories = RiskCategory::all();
        return view('risks.create', compact('categories'));
    }

    // Store new risk
    public function store(Request $request)
    {
        $request->validate([
            'risk_title' => 'required|string|max:100',
            'category_id' => 'required|exists:risk_categories,Category_ID',
            'risk_level' => 'required|in:Low,Medium,High,Critical',
            'description' => 'required|string'
        ]);

        Risk::create([
            'Category_ID' => $request->category_id,
            'Reported_by' => Session::get('user_id'),
            'Risk_Title' => $request->risk_title,
            'Risk_Level' => $request->risk_level,
            'Description' => $request->description,
            'Created_at' => now()
        ]);

        return redirect()->route('risks.index')->with('success', 'Risk added successfully!');
    }

    // Show edit form
    public function edit($id)
    {
        if (!Session::get('is_logged_in')) {
            return redirect()->route('login');
        }
        
        $risk = Risk::findOrFail($id);
        $categories = RiskCategory::all();
        return view('risks.edit', compact('risk', 'categories'));
    }

    // Update risk
    public function update(Request $request, $id)
    {
        $request->validate([
            'risk_title' => 'required|string|max:100',
            'category_id' => 'required|exists:risk_categories,Category_ID',
            'risk_level' => 'required|in:Low,Medium,High,Critical',
            'description' => 'required|string'
        ]);

        $risk = Risk::findOrFail($id);
        $risk->update([
            'Category_ID' => $request->category_id,
            'Risk_Title' => $request->risk_title,
            'Risk_Level' => $request->risk_level,
            'Description' => $request->description
        ]);

        return redirect()->route('risks.index')->with('success', 'Risk updated successfully!');
    }

    // Delete risk
    public function destroy($id)
    {
        $risk = Risk::findOrFail($id);
        $risk->delete();

        return redirect()->route('risks.index')->with('success', 'Risk deleted successfully!');
    }
}