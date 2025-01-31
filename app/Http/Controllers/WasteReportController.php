<?php

namespace App\Http\Controllers;

use App\Models\WasteReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Stevebauman\Location\Facades\Location;

class WasteReportController extends Controller
{
  public function index()
  {
    $reports = auth()->user()->wasteReports()->latest()->paginate(10);
    return view('waste-reports.index', compact('reports'));
  }

  public function create()
  {
    // Get user's location from IP
    $position = Location::get();

    return view('waste-reports.create', [
      'initialLocation' => $position ? [
        'latitude' => $position->latitude,
        'longitude' => $position->longitude,
        'address' => $position->cityName . ', ' . $position->regionName . ', ' . $position->countryName
      ] : null
    ]);
  }

  public function store(Request $request)
  {
    $request->validate([
      'photo' => 'required|image|max:2048', // max 2MB
      'location' => 'required|string',
      'latitude' => 'required|numeric',
      'longitude' => 'required|numeric',
      'description' => 'nullable|string'
    ]);

    $path = $request->file('photo')->store('waste-reports', 'public');

    auth()->user()->wasteReports()->create([
      'photo' => $path,
      'location' => $request->location,
      'latitude' => $request->latitude,
      'longitude' => $request->longitude,
      'description' => $request->description
    ]);

    return redirect()->route('waste-reports.index')
      ->with('success', 'Laporan sampah berhasil dikirim!');
  }

  public function edit($id)
  {
    $report = WasteReport::findOrFail($id);

    if ($report->status !== 'pending') {
      return redirect()->route('waste-reports.index')
        ->with('error', 'Laporan yang sudah aktif tidak dapat diedit.');
    }

    return view('waste-reports.edit', compact('report'));
  }

  public function destroy(WasteReport $wasteReport)
  {
    if ($wasteReport->status !== 'pending') {
      return redirect()->route('waste-reports.index')
        ->with('error', 'Laporan yang sudah aktif tidak dapat dihapus.');
    }

    // Hapus foto
    Storage::delete($wasteReport->photo);

    // Hapus record
    $wasteReport->delete();

    return redirect()->route('waste-reports.index')
      ->with('success', 'Laporan berhasil dihapus.');
  }

  public function update(Request $request, $id)
  {
    $report = WasteReport::findOrFail($id);

    if ($report->status !== 'pending') {
      return redirect()->route('waste-reports.index')
        ->with('error', 'Laporan yang sudah aktif tidak dapat diedit.');
    }

    $request->validate([
      'location' => 'required',
      'latitude' => 'required',
      'longitude' => 'required',
      'photo' => 'image|mimes:jpeg,png,jpg|max:2048'
    ]);

    $data = $request->only(['location', 'latitude', 'longitude', 'description']);

    if ($request->hasFile('photo')) {
      // Hapus foto lama
      Storage::disk('public')->delete($report->photo);

      // Upload foto baru
      $data['photo'] = $request->file('photo')->store('waste-reports', 'public');
    }

    $report->update($data);

    return redirect()->route('waste-reports.index')
      ->with('success', 'Laporan berhasil diupdate.');
  }
}
