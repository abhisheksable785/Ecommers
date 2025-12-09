<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    // ✅ STORE ADDRESS
    public function store(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'type'    => 'required',
            'name'    => 'required',
            'mobile'  => 'required',
            'pincode' => 'required',
            'state'   => 'required',
            'house'   => 'required',
            'area'    => 'required',
            'city'    => 'required',
        ]);

        $address = Address::create([
            'user_id' => auth()->id(),
            'type'    => $request->type,
            'name'    => $request->name,
            'mobile'  => $request->mobile,
            'pincode' => $request->pincode,
            'state'   => $request->state,
            'house'   => $request->house,
            'area'    => $request->area,
            'city'    => $request->city,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Address saved successfully',
            'data'    => $address,
        ]);
    }

    // ✅ GET ALL USER ADDRESSES
    public function index()
    {
        $addresses = Address::where('user_id', auth()->id())->get();

        return response()->json([
            'success' => true,
            'data' => $addresses,
        ]);
    }

    // ✅ DELETE ADDRESS
    public function delete($id)
    {
        $address = Address::where('user_id', auth()->id())->findOrFail($id);
        $address->delete();

        return response()->json([
            'success' => true,
            'message' => 'Address deleted',
        ]);
    }

    // ✅ SET DEFAULT ADDRESS
    public function setDefault($id)
    {
        Address::where('user_id', auth()->id())->update([
            'is_default' => false,
        ]);

        Address::where('user_id', auth()->id())
            ->where('id', $id)
            ->update([
                'is_default' => true,
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Default address updated',
        ]);
    }
}

