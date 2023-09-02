<?php

namespace App\Http\Controllers;

use App\Models\ActionSlip;
use Illuminate\Http\Request;

class ActionSlipController extends Controller
{
    /**
     * Display a listing of the action_slips.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $actionSlips = ActionSlip::all();
        return view('action_slips.index', compact('actionSlips'));
    }

    /**
     * Show the form for creating a new action_slip.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('action_slips.create');
    }

    /**
     * Store a newly created action_slip in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
        ]);
    
        $actionSlip = ActionSlip::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);
    
        // Redirect to the reports.show route with the action slip ID
        return redirect()->route('reports.show', ['report' => $actionSlip->id])
        ->with('success', 'Action Slip created successfully');
    
    }
    

    /**
     * Display the specified action_slip.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $actionSlip = ActionSlip::findOrFail($id);
        return view('action_slips.show', compact('actionSlip'));
    }

    /**
     * Show the form for editing the specified action_slip.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $actionSlip = ActionSlip::findOrFail($id);
        return view('action_slips.edit', compact('actionSlip'));
    }

    /**
     * Update the specified action_slip in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
        ]);

        // Update the action_slip record
        $actionSlip = ActionSlip::findOrFail($id);
        $actionSlip->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        return redirect()->route('action_slips.index')
            ->with('success', 'Action Slip updated successfully');
    }

    /**
     * Remove the specified action_slip from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $actionSlip = ActionSlip::findOrFail($id);
        $actionSlip->delete();

        return redirect()->route('action_slips.index')
            ->with('success', 'Action Slip deleted successfully');
    }
}
