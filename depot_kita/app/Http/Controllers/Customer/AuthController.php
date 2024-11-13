<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('customer.login'); // show the login form
    }
    
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Use the correct guard name ('customer' in lowercase)
        if (Auth::guard('customer')->attempt($credentials)) {
            // Authentication was successful, redirect to the 'customer/order' route
            return redirect()->route('customer.order'); 
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ]);
    }

    // The 'order' method which returns the 'customer/order' view
    public function order()
    {
        // Check if the logged-in user is a customer
        if (Auth::guard('customer')->check()) {
            // User is logged in as a customer
            return view('customer.order'); // Show the order page
        }

        // Redirect to login page if not logged in as a customer
        return redirect()->route('customer.login')->withErrors('You must be logged in as a customer to view this page.');
    }
}
