<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('customer.login'); // create a view for the customer login form
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Use the correct guard name ('customer' in lowercase)
        if (Auth::guard('customer')->attempt($credentials)) {
            // Authentication was successful...
            return redirect()->intended('/customer/order'); // specify customer dashboard route
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ]);
    }
}
