<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index()
    {
        $colors = Color::all();
        return view('admin.products.product_color', compact('colors'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',

        ]);
        $color = Color::create([
            'name' => $request->name,
        ]);
        if (!$color) {
            return redirect()->back()->with('error', 'An Error Occuer');
        }
        return redirect()->route('color.index')->with('message', 'Color ' . $color->name . ' added successfully');
    }

    public function destroy(Color $color)
    {
        $color->delete();
        return redirect()->back()->with('message', 'Color Deleted');
    }
}
