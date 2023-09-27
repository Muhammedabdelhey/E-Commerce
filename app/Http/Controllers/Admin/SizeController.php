<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function index(){
        $sizes=Size::all();
        return view('admin.products.product_size',compact('sizes'));
    }
    public function store(Request $request){
        $request->validate([
            'name' => 'required',
        ]);
        $size=Size::create([
            'name'=>$request->name,
            'abbreviation' => $request->abbreviation,

        ]);
        if (!$size) {
            return redirect()->back()->with('error', 'An Error Occuer');
        }
        return redirect()->route('size.index')->with('message', 'size ' . $size->name . ' added successfully');
    }

    public function destroy(Size $size){
        $size->delete();
        return redirect()->back()->with('message', 'Size Deleted');
    }
}
