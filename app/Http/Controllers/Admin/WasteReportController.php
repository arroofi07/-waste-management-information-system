<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WasteReport;
use Illuminate\Http\Request;

class WasteReportController extends Controller
{
  public function index()
  {
    $reports = WasteReport::with('user')
      ->latest()
      ->paginate(10);

    return view('admin.waste-reports.index', compact('reports'));
  }

  public function updateStatus(Request $request, $id)
  {
    $report = WasteReport::findOrFail($id);

    // Pastikan status yang dikirim sesuai dengan yang ada di database
    if (in_array($request->status, ['pending', 'processed', 'completed'])) {
      $report->status = $request->status;  // Set langsung tanpa forceFill
      $report->save();

      return back()->with('success', 'Status berhasil diupdate');
    }

    return back()->with('error', 'Status tidak valid');
  }

  public function show($id)
  {
    $report = WasteReport::with('user')->findOrFail($id);
    return view('admin.waste-reports.show', compact('report'));
  }
}
