<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SliderImage;
use Illuminate\Support\Facades\Storage;

class SliderImageController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(['role:admin,publisher'])->except(['index']);
    }

    public function index()
    {
        $images = SliderImage::orderBy('order')->where('active', true)->get();
        return view('slider.index', compact('images'));
    }

    public function manage()
    {
        $images = SliderImage::orderBy('order')->get();
        return view('slider.manage', compact('images'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $path = $request->file('image')->store('slider', 'public');

        SliderImage::create([
            'image_path' => $path,
            'title' => $request->title,
            'description' => $request->description,
            'order' => SliderImage::count()
        ]);

        return redirect()->route('slider.manage')->with('success', 'Imagen agregada correctamente');
    }

    public function update(Request $request, SliderImage $image)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'active' => 'boolean'
        ]);

        $image->update($request->all());
        return redirect()->route('slider.manage')->with('success', 'Imagen actualizada correctamente');
    }

    public function destroy(SliderImage $image)
    {
        Storage::disk('public')->delete($image->image_path);
        $image->delete();
        return redirect()->route('slider.manage')->with('success', 'Imagen eliminada correctamente');
    }

    public function updateOrder(Request $request)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*' => 'integer'
        ]);

        foreach ($request->orders as $id => $order) {
            SliderImage::where('id', $id)->update(['order' => $order]);
        }

        return response()->json(['success' => true]);
    }
}