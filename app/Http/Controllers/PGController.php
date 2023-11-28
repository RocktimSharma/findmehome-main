<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\PG; // Import the PG model

class PGController extends Controller
{
    public function create()
    {
        return view('addPg');
    }


    public function search(Request $request)
    {
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        
        // Set the search radius to 50 kilometers
        $radius = 50;
        $minRoomPrice=$request->input('minRoomPrice');
        $maxRoomPrice=$request->input('maxRoomPrice');
        $roomTypes=$request->input('roomType');
        $amenities=$request->input('amenities');

        $owner = Auth::user();
        $userId = auth()->user()->id; // Replace this with your actual logic to get the current user's ID

  
      /*  $pgs = DB::table('pgs')
    ->select('pgs.*', 'room.room_type', 'room.room_price', 'room.amenities')
    ->selectRaw(
        '(
            6371 * acos(
                cos(radians(?)) * cos(radians(pgs.latitude)) * cos(radians(pgs.longitude) - radians(?)) + sin(radians(?)) * sin(radians(pgs.latitude))
            )
        ) AS distance',
        [$latitude, $longitude, $latitude]
    )
    ->join('room', 'pgs.pg_id', '=', 'room.pg_id')
    ->where('room.availability_status', '=', 'available')
    ->having('distance', '<', $radius)
    ->get();*/

    $pgs = DB::table('pgs')
    ->select('pgs.*','room.room_id', 'room.room_type', 'room.room_price', 'room.amenities','room.image1','users.id',
    
    DB::raw('wishlist.room_id IS NOT NULL AS wishlisted'))
    ->selectRaw(
        '(
            6371 * acos(
                cos(radians(?)) * cos(radians(pgs.latitude)) * cos(radians(pgs.longitude) - radians(?)) + sin(radians(?)) * sin(radians(pgs.latitude))
            )
        ) AS distance',
        [$latitude, $longitude, $latitude]
    )
    ->join('room', 'pgs.pg_id', '=', 'room.pg_id')
    ->join('users','pgs.owner_id','=','users.id')
    ->leftJoin('wishlist', function ($join) use ($userId) {
        $join->on('room.room_id', '=', 'wishlist.room_id')
            ->where('wishlist.user_id', '=', $userId);
    })
    ->where('room.availability_status', '=', 'available')
    ->where(function ($query) use ($minRoomPrice, $maxRoomPrice, $roomTypes, $amenities,$owner) {
        if ($minRoomPrice) {
            $query->where('room.room_price', '>=', $minRoomPrice);
        }

        if ($maxRoomPrice) {
            $query->where('room.room_price', '<=', $maxRoomPrice);
        }

  

        if (!empty($roomTypes)) {
            $query->where(function ($query) use ($roomTypes) {
                foreach ($roomTypes as $roomType) {
                    $query->orWhere('room.room_type','=', $roomType);
                }
            });
        }

        if (!empty($amenities)) {
            $query->where(function ($query) use ($amenities) {
                foreach ($amenities as $amenity) {
                    $query->orWhere('room.amenities', 'like', '%' . $amenity . '%');
                }
            });
        }
        $query->where('pgs.owner_id', '!=', $owner->id);
    })
    ->having('distance', '<', $radius)
   
    ->get(); 
  
  
    
        return response()->json($pgs);
    }
    
    
    
    
// ...

public function destroy(PG $pg)
{
    // Delete the room
    $pg->delete();

    // Redirect to a page after deleting the room
    return redirect()->back()->with('success', 'Room deleted successfully.');
}

public function showPgUpdate($pgId)
{
    $pg = PG::find($pgId);
    return view('editPg', ['pg' => $pg]);
}

public function update(Request $request, $pgId){
    $validatedData = $request->validate([
        'name' => 'required|string',
        'latitude' => 'required|string',
        'longitude' => 'required|string',
        'contact_details' => 'required|string',
        'rules_restrictions' => 'required|string',
        'description' => 'required|string',
     
       
    ]);

   $pg=PG::find( $pgId );
    // Create a new Pg model instance and populate it with the validated data
       // Handle image upload

    $pg->update($validatedData);

    // Save the map coordinates
    $pg->latitude = $request->input('latitude');
    $pg->longitude = $request->input('longitude');

    $pg->save();

 //   return redirect()->back()->with('success','PG updated successfully');
 $userId = auth()->user()->id;
            // $userId now contains the ID of the authenticated user
         
         
            // Use Eloquent to fetch PGs with the specified owner_id
            $pgs = PG::where('owner_id', $userId)->get();
         

        
            return redirect()->route('myPgs')->with(['pgs' => $pgs, 'success' => 'PG updated successfully']);

 
}

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
            'rules_restrictions' => 'required|string',
            'description' => 'required|string',
         
           
        ]);

        $validatedData['owner_id'] = $owner->id;

 
        // Create a new Pg model instance and populate it with the validated data
           // Handle image upload
  
        $pg = new PG($validatedData);
 
        // Save the map coordinates
        $pg->latitude = $request->input('latitude');
        $pg->longitude = $request->input('longitude');
    
        // Save the Pg to the database
      
        try {
            $pg->save();
         
         //  return redirect('/add-pg')->with('success', 'PG created successfully!');
         $userId = auth()->user()->id;
            // $userId now contains the ID of the authenticated user
         
         
            // Use Eloquent to fetch PGs with the specified owner_id
            $pgs = PG::where('owner_id', $userId)->get();
         
            return redirect()->route('myPgs')->with(['pgs' => $pgs, 'success' => 'PG added successfully']);

            
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
