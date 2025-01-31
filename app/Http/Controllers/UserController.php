<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
  public function index()
  {
    $users = User::where('role', 'masyarakat')->paginate(10);
    return view('users.index', compact('users'));
  }

  public function create()
  {
    return view('users.create');
  }

  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|unique:users',
      'password' => 'required|string|min:8',
      'phone_number' => 'nullable|string|max:15',
      'address' => 'nullable|string'
    ]);

    User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => Hash::make($request->password),
      'phone_number' => $request->phone_number,
      'address' => $request->address,
      'role' => 'masyarakat'
    ]);

    return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan');
  }

  public function edit(User $user)
  {
    return view('users.edit', compact('user'));
  }

  public function update(Request $request, User $user)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|unique:users,email,' . $user->id,
      'phone_number' => 'nullable|string|max:15',
      'address' => 'nullable|string'
    ]);

    $user->update($request->all());
    return redirect()->route('users.index')->with('success', 'User berhasil diperbarui');
  }

  public function destroy(User $user)
  {
    $user->delete();
    return redirect()->route('users.index')->with('success', 'User berhasil dihapus');
  }
}
