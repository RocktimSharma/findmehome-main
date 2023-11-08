<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room; // Import the Room model
use App\Models\PG;
class RoomController extends Controller
{
    public function create($pg_id) {
        // Load the view for the form, passing the $pg_id to the view
        return view('addRoom', ['pg_id' => $pg_id]);
    }

    public function destroy(Room $room)
{
    // Delete the room
    $room->delete();

    // Redirect to a page after deleting the room
    return redirect()->back()->with('success', 'Room deleted successfully.');
}

    public function getRoomsByPG($pg_id) {
        $pg = PG::find($pg_id);

        if (!$pg) {
            // Handle the case when the PG doesn't exist (e.g., return an error response)
        }
    
        // Retrieve all rooms associated with the PG
        $rooms = $pg->rooms;
    
        return view('rooms', ['pg' => $pg, 'rooms' => $rooms]);
    }
    
    public function store(Request $request, $pg_id)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'image1' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'image2' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'image3' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'image4' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'room_type' => 'required|in:Single,Double,Triple,Other',
            'availability_status'=>'required|string',
            'room_price'=>'required|string',
            'amenities' => 'array',
           // Adjust the amenities list
          
        ]);
    
        // Convert the array of amenities to a comma-separated string
        $amenities = implode(',', $validatedData['amenities']);
    
        // Create a new Room model instance and populate it with the validated data
    // Debugging statement

    if ($request->hasFile('image1')) {
        $imagePath = $request->file('image1')->store('pgs-images', 'public');
        $validatedData['image1'] = $imagePath;
    }
    if ($request->hasFile('image2')) {
        $imagePath = $request->file('image2')->store('pgs-images', 'public');
        $validatedData['image2'] = $imagePath;
    }
    if ($request->hasFile('image3')) {
        $imagePath = $request->file('image3')->store('pgs-images', 'public');
        $validatedData['image3'] = $imagePath;
    }
    if ($request->hasFile('image4')) {
        $imagePath = $request->file('image4')->store('pgs-images', 'public');
        $validatedData['image4'] = $imagePath;
    }
// Create a new Room model instance and populate it with the validated data
/*$room = new Room([
    'image1'=> $validatedData['image1'],
    'image2'=> $validatedData['image2'],
    'image3'=> $validatedData['image3'],
    'image4'=> $validatedData['image4'],
    'room_type' => $validatedData['room_type'],
    'amenities' => $amenities,
    'room_price' => $validatedData['room_price'], // Make sure this is correctly set
    'availability_status' => $validatedData['availability_status'], // Make sure this is correctly set
]);*/

$room=new Room($validatedData);

$room->amenities=$amenities;


        $room->pg_id = $pg_id; // Set the pg_id from the URL
    
        // Save the Room to the database
        $room->save();
    
        // Redirect to a success page or return a response
        // ...
    
        return redirect()->back()->with('success', 'Room created successfully!');
    }
    
}
