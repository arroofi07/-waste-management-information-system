<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CollectorController extends Controller
{
  public function index()
  {
    $collectors = User::where('role', 'collector')
      ->latest()
      ->get();

    return view('admin.collectors.index', compact('collectors'));
  }

  public function create()
  {
    return view('admin.collectors.create');
  }

  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users',
      'phone_number' => 'required|string|max:20',
      'vehicle_number' => 'required|string|max:20',
      'vehicle_type' => 'required|in:truck,pickup,motorcycle',
      'password' => 'required|string|min:8|confirmed',
    ]);

    $collector = User::create([
      'name' => $request->name,
      'email' => $request->email,
      'phone_number' => $request->phone_number,
      'vehicle_number' => $request->vehicle_number,
      'vehicle_type' => $request->vehicle_type,
      'password' => Hash::make($request->password),
      'role' => 'collector',
    ]);

    return redirect()
      ->route('admin.collectors.index')
      ->with('success', 'Pengangkut sampah berhasil ditambahkan');
  }

  public function edit(User $collector)
  {
    return view('admin.collectors.edit', compact('collector'));
  }

  public function update(Request $request, User $collector)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users,email,' . $collector->id,
      'phone_number' => 'required|string|max:20',
      'vehicle_number' => 'required|string|max:20',
      'vehicle_type' => 'required|in:truck,pickup,motorcycle',
      'password' => 'nullable|string|min:8|confirmed',
    ]);

    $collector->update([
      'name' => $request->name,
      'email' => $request->email,
      'phone_number' => $request->phone_number,
      'vehicle_number' => $request->vehicle_number,
      'vehicle_type' => $request->vehicle_type,
    ]);

    if ($request->filled('password')) {
      $collector->update(['password' => Hash::make($request->password)]);
    }

    return redirect()
      ->route('admin.collectors.index')
      ->with('success', 'Data pengangkut sampah berhasil diperbarui');
  }

  public function destroy(User $collector)
  {
    $collector->delete();

    return redirect()
      ->route('admin.collectors.index')
      ->with('success', 'Pengangkut sampah berhasil dihapus');
  }
}
