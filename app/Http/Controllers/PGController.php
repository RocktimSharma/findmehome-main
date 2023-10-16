<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PG; // Import the PG model

class PGController extends Controller
{
    public function create()
    {
        return view('addPg');
    }

 

// ...

public function store(Request $request)
{

    // Check if a user is authenticated
    if (Auth::check()) {
        // Get the currently authenticated owner
        $owner = Auth::user();

        $validatedData = $request->validate([
            'name' => 'required|string',
            'latitude' => 'required|string',
            'longitude' => 'required|string',
            'contact_details' => 'required|string',
            'amenities' => 'required|string',
            'rules_restrictions' => 'required|string',
            'description' => 'required|string',
            'other_details' => 'required|string',
        ]);
 
        // Create a new Pg model instance and populate it with the validated data
        $pg = new PG($validatedData);
 
        // Save the map coordinates
        $pg->latitude = $request->input('latitude');
        $pg->longitude = $request->input('longitude');
    
        // Save the Pg to the database
      
        try {
            $pg->save();
         
           return redirect('/add-pg')->with('success', 'PG created successfully!');
            
        } catch (\Exception $e) {
            echo $e;
            //return redirect('/')->with('error', 'Error occurred while saving data.');
        }
    } else {
        // Handle the case where no user is authenticated
        return redirect('/login')->with('error', 'You must be logged in to create a PG.');
    }

    
}

}
