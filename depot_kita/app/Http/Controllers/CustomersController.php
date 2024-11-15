<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $Customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $Customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $Customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $Customer)
    {
        //
    }

    public function profile()
    {
        // Render profile view for the logged-in customer
        return view('customer.profile', ['customer' => Auth::guard('customer')->user()]);
    }

    // CustomerController.php
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/customer/login');  // Redirect to the login page or wherever you wish.
    }

    public function showRegistrationForm()
    {
        return view('customer.register');
    }

    // Handle the registration
    public function register(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:Customer,email',
            'phone_number' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Handle validation errors
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Create the customer
        $customer = new Customer();
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phone_number = $request->phone_number;
        $customer->password = Hash::make($request->password);
        $customer->save();

        // Redirect to login or home page after successful registration
        return redirect()->route('customer.login')->with('success', 'Registration successful! Please log in.');
    }
}
