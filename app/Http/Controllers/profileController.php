<?php

namespace App\Http\Controllers;

use App\Models\AddToBag;
use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class profileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $profile= Profile::where('user_id',auth()->id())->first();

    return view('page.profile', compact('profile'));
    }
    
    public function apiIndex(){
        $profile = Profile::all();

        return response()->json([
            'status'=>true,
            'message'=>'data retreive successfully',
            'data'=> ['profile' => $profile]
        ]);
    }
  

 
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    //    return $request;
        $user = auth()->user();
           $request->validate([
        'full_name' => 'required|string|max:255',
        'mobile_number' => 'required|numeric',
        'email' => 'required|email',
        'birthday' => 'required|date',
        'address' => 'required|string',
        'city' => 'required|string',
        'pincode' => 'required|numeric',
    ]);
           Profile::updateOrCreate(
        ['user_id' => $user->id], // Search condition
        [ // Data to update or insert
            'full_name' => $request->full_name,
            'mobile_number' => $request->mobile_number,
            'email' => $request->email,
            'birthday' => $request->birthday,
            'address' => $request->address,
            'city' => $request->city,
            'pincode' => $request->pincode,
        ]
    );
        return redirect()->back()->with('success', 'Profile added successfully!');
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {
         $this->store($request); // You can reuse store logic
    return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
