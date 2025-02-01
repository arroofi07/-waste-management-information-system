<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
  use AuthenticatesUsers;

  protected $redirectTo = RouteServiceProvider::HOME;

  public function __construct()
  {
    $this->middleware('guest')->except('logout');
  }

  // Override method authenticated untuk custom redirect
  protected function authenticated(Request $request, $user)
  {
    if ($user->email === 'admin@gmail.com') {
      return redirect()->route('admin.waste-reports.index');
    }

    return redirect()->intended($this->redirectPath());
  }
}
