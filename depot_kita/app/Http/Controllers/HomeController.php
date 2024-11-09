<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
  public function index()
  {
    $user = Auth::user();

    // Check the user's role and return the corresponding view
    if ($user->role === 'admin') {
      return view('admin.dashboard', compact('user'));  // Admin dashboard
    }

    if ($user->role === 'employee') {
      return view('employee.dashboard', compact('user'));  // Employee dashboard
    }

    // Optionally handle other roles or redirect if no matching role found
    return redirect()->route('login');  // Redirect to login if role doesn't match
  }
}
