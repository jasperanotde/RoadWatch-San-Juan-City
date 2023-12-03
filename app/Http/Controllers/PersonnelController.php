<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Personnel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersonnelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Fetch users with the role of City Engineer
        $cityEngineers = User::whereHas('roles', function ($query) {
            $query->where('name', 'City Engineer');
        })->paginate(10);

        $personnel = [];

        foreach ($cityEngineers as $cityEngineer) {
            $personnelForEngineer = DB::table('users')
                ->join('personnels', 'users.id', '=', 'personnels.user_id')
                ->where('users.id', $cityEngineer->id)
                ->select('personnels.*')
                ->get();

            // Store personnel data for each City Engineer in the array
            $personnel[$cityEngineer->id] = $personnelForEngineer;
        }
        
        return view('personnels.index', compact('cityEngineers', 'personnel'))
        ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
       //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $cityEngineer = User::findOrFail($id);
        
        // Retrieve personnel inputs from the request
        $personnelInputs = $request->input('personnel');

        foreach ($personnelInputs as $personnelName) {
            // Check if the personnel already exists for the engineer
            $existingPersonnel = Personnel::where('user_id', $cityEngineer->id)
                                          ->where('name', $personnelName)
                                          ->first();

            // If the personnel doesn't exist for the engineer, create it
            if (!$existingPersonnel) {
                $personnel = new Personnel();
                $personnel->name = $personnelName;
                $personnel->user_id = $cityEngineer->id;
                $personnel->save();
            }
        }
        
        return redirect()->route('personnels.index')->with('success', 'Personnel added/updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
