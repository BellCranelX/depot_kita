<?php

namespace App\Http\Controllers;

use App\Models\menus;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = menus::where('active', 1)->get(); // Assuming you want to show only active menus
        return view('admin.menu', compact('menus'));
    }


    public function store(Request $request)
    {
        // Validate the input data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'stock' => 'required|integer',
        ]);

        // Retrieve the original filename and prepend it with a timestamp for uniqueness
        $originalFilename = time() . '_' . $request->file('image')->getClientOriginalName();

        // Move the file to the 'public/assets' directory with the specified filename
        $request->file('image')->move(public_path('menu'), $originalFilename);

        // Create a new product record
        $menu = new menus();
        $menu->name = $validatedData['name'];
        $menu->description = $validatedData['description'];
        $menu->price = $validatedData['price'];
        $menu->image_url = $originalFilename; // Save the original filename with timestamp
        $menu->stock = $validatedData['stock'];
        $menu->active = 1; // Set the product to active by default
        $menu->save();

        // Redirect back to the menu page with a success message
        return redirect()->route('menus.index')->with('success', 'New menu item added!');
    }

    public function destroy($id)
    {
        // Find the menu item by ID
        $menu = menus::findOrFail($id);

        // Set the menu item as inactive by changing 'active' to 0
        $menu->active = 0;
        $menu->save();

        // Redirect back to the menu page with a success message
        return redirect()->route('menus.index')->with('success', 'Menu item has been deleted (marked as inactive).');
    }
}
