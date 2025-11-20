<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index()
    {
        return response()->json([
            "status" => true,
            "sliders" => Slider::all()
        ]);
    }


    public function showSliderPage()
{
    $sliders = Slider::all();
    return view('admin.sliders', compact('sliders'));
}

public function delete($id)
{
    $slider = Slider::findOrFail($id);

    if (file_exists(public_path($slider->image))) {
        unlink(public_path($slider->image));
    }

    $slider->delete();

    return redirect()->back()->with('success', 'Slider Deleted Successfully');
}


    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image'
        ]);

        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('slider'), $imageName);

        Slider::create([
            'image' => 'slider/' . $imageName
        ]);

        return back()->with('success', 'Slider Added Successfully');
    }
}