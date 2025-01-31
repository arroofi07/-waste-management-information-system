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

    $request->validate([
      'status' => 'required|in:pending,active,completed'
    ]);

    $report->update([
      'status' => $request->status
    ]);

    return back()->with('success', 'Status berhasil diupdate');
  }

  public function show($id)
  {
    $report = WasteReport::with('user')->findOrFail($id);
    return view('admin.waste-reports.show', compact('report'));
  }
}
