<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PG;
class UserPgController extends Controller
{
    //// UserPgController.php

 

    public function index()
    {
       
       
            $userId = auth()->user()->id;
            // $userId now contains the ID of the authenticated user
         
         
            // Use Eloquent to fetch PGs with the specified owner_id
            $pgs = PG::where('owner_id', $userId)->get();
         

        
    return view('myPgs', ['pgs' => $pgs]);
    }

}