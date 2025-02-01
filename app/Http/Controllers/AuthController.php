<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
  public function showLogin()
  {
    return view('auth.login');
  }

  public function showRegister()
  {
    return view('auth.register');
  }

  public function login(Request $request)
  {
    $credentials = $request->validate([
      'email' => 'required|email',
      'password' => 'required'
    ]);

    if (Auth::attempt($credentials)) {
      $request->session()->regenerate();
      $user = Auth::user();

      if ($user->role === 'admin') {
        session()->flash('success', 'Selamat datang Admin!');
        return redirect()->route('admin.waste-reports.index');
      } elseif ($user->role === 'collector') {
        session()->flash('success', 'Selamat datang Pengangkut Sampah!');
        return redirect()->route('collector.waste-reports.index');
      } else {
        session()->flash('success', 'Berhasil login!');
        return redirect()->route('waste-reports.index');
      }
    }

    return back()->withErrors([
      'email' => 'Email atau password salah.',
    ])->with('error', 'Email atau password salah!');
  }

  public function register(Request $request)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|unique:users',
      'password' => 'required|string|min:8|confirmed',
      'phone_number' => 'required|string|max:15',
      'address' => 'required|string'
    ]);

    $user = User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => Hash::make($request->password),
      'phone_number' => $request->phone_number,
      'address' => $request->address,
      'role' => 'masyarakat', // Role selalu masyarakat
      'reward_points' => 0 // Inisialisasi poin reward
    ]);

    Auth::login($user);

    // Tambahkan pesan sukses
    session()->flash('success', 'Registrasi berhasil!');

    // Redirect ke waste-reports
    return redirect()->route('waste-reports.index');
  }

  public function logout(Request $request)
  {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    // Tambahkan pesan sukses
    session()->flash('success', 'Berhasil logout!');

    return redirect('/');
  }
}
