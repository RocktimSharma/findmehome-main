<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Room; // Import the Room model
use App\Models\PG;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Storage;
class RoomController extends Controller
{
    public function create($pg_id)
    {
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

    public function update(Request $request,$roomId)
    {

        $validatedData = $request->validate([
            'image1' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'image2' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'image3' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'image4' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'room_type' => 'required|in:Single,Double,Triple,Other',
            'availability_status' => 'required|string',
            'room_price' => 'required|string',
            'amenities' => 'array',
            // Adjust the amenities list

        ]);

        $room = Room::find($roomId);

        if ($request->hasFile('image1')) {
            if (!empty($room->image1)) {
                Storage::disk('public')->delete($room->image1);
            }
            // Handle the new image
            $newImagePath = $request->file('image1')->store('pgs-images', 'public'); // Adjust the storage path as needed
    
            // Update the room with the new image path
            $room->image1 = $newImagePath;
        }

        if ($request->hasFile('image2')) {
            if (!empty($room->image2)) {
                Storage::disk('public')->delete($room->image2);
            }
            // Handle the new image
            $newImagePath = $request->file('image2')->store('pgs-images', 'public'); // Adjust the storage path as needed
    
            // Update the room with the new image path
            $room->image1 = $newImagePath;
        }

        if ($request->hasFile('image3')) {
            if (!empty($room->image3)) {
                Storage::disk('public')->delete($room->image3);
            }
            // Handle the new image
            $newImagePath = $request->file('image3')->store('pgs-images', 'public'); // Adjust the storage path as needed
    
            // Update the room with the new image path
            $room->image1 = $newImagePath;
        }

        if ($request->hasFile('image4')) {

            if (!empty($room->image4)) {
                Storage::disk('public')->delete($room->image4);
            }
            // Handle the new image
            $newImagePath = $request->file('image4')->store('pgs-images', 'public'); // Adjust the storage path as needed
    
            // Update the room with the new image path
            $room->image1 = $newImagePath;
        }

        $amenities = implode(',', $validatedData['amenities']);

        $room->room_price = $validatedData['room_price'];
        $room->room_type = $validatedData['room_type'];
        $room->availability_status = $validatedData['availability_status'];

        $room->amenities=$amenities;


        $room->save();

        return redirect()->back()->with('success', 'Room updated successfully!');
        
 
    }


    public function showRoomUpdate($roomId)
    {
        $room = Room::find($roomId);
        return view('editRoom', ['room' => $room]);
    }
    public function getRoomsByPG($pg_id)
    {
        $pg = PG::find($pg_id);

        if (!$pg) {
            // Handle the case when the PG doesn't exist (e.g., return an error response)
        }

        // Retrieve all rooms associated with the PG
        $rooms = $pg->rooms;

        return view('rooms', ['pg' => $pg, 'rooms' => $rooms]);
    }

    public function addtoWishlist($room_id)
    {
        $userId = Auth::user()->id;
        $wishlist = new Wishlist();
        $wishlist->user_id = $userId;
        $wishlist->room_id = $room_id;

        // Save the wishlist entry to the database
        $wishlist->save();

        return redirect()->back()->with('success', true);

    }

    public function removefromWishlist($room_id)
    {
        $userId = Auth::user()->id;
        DB::table('wishlist')
            ->where('user_id', $userId)
            ->where('room_id', $room_id)
            ->delete();

        return redirect()->back()->with('success', '');

    }

    public function displayRoom($roomId)
    {
        $roomData = Room::select('room.*', 'pgs.*')
            ->join('pgs', 'room.pg_id', '=', 'pgs.pg_id')
            ->where('room.room_id', '=', $roomId)
            ->first();

        return view('room', ['room' => $roomData]);
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
            'availability_status' => 'required|string',
            'room_price' => 'required|string',
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

        $room = new Room($validatedData);

        $room->amenities = $amenities;


        $room->pg_id = $pg_id; // Set the pg_id from the URL

        // Save the Room to the database
        $room->save();

        // Redirect to a success page or return a response
        // ...

        return redirect()->back()->with('success', 'Room created successfully!');
    }

    public function wishlist(){

        $userId = Auth::user()->id;
        $wishlist = DB::table('wishlist')
        ->select('pgs.*', 'room.*', 'users.id')
    ->leftJoin('users', 'wishlist.user_id', '=', 'users.id')
    ->leftJoin('room', 'wishlist.room_id', '=', 'room.room_id')
    ->leftJoin('pgs', 'room.pg_id', '=', 'pgs.pg_id')
    
    ->where('wishlist.user_id',"=", $userId)
    ->get();
        
        return view('wishlist',['wishlists'=> $wishlist]);
    }

}
