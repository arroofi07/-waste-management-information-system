<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;

class CollectorRegisterController extends Controller
{
  /**
   * Show the application registration form.
   *
   * @return \Illuminate\View\View
   */
  public function showRegistrationForm()
  {
    return view('auth.collector-register');
  }

  /**
   * Handle a registration request for the application.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
   */
  public function register(Request $request)
  {
    $request->validate([
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
      'phone_number' => ['required', 'string', 'max:15'],
      'password' => ['required', 'string', 'min:8', 'confirmed'],
      'vehicle_number' => ['required', 'string', 'max:20'],
      'vehicle_type' => ['required', 'string', 'max:50'],
    ]);

    $user = User::create([
      'name' => $request->name,
      'email' => $request->email,
      'phone_number' => $request->phone_number,
      'password' => Hash::make($request->password),
      'role' => 'collector',
      'vehicle_number' => $request->vehicle_number,
      'vehicle_type' => $request->vehicle_type,
      'address' => $request->address ?? null,
    ]);

    event(new Registered($user));

    Auth::login($user);

    return redirect('/collector/waste-reports');
  }
}
