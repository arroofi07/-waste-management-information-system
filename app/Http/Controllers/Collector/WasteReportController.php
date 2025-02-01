<?php

namespace App\Http\Controllers\Collector;

use App\Http\Controllers\Controller;
use App\Models\WasteReport;
use Illuminate\Http\Request;

class WasteReportController extends Controller
{
  public function index()
  {
    $reports = WasteReport::where('status', 'processed')
      ->orderBy('created_at', 'desc')
      ->paginate(10);

    return view('collector.waste-reports.index', compact('reports'));
  }

  public function show($id)
  {
    $report = WasteReport::where('status', 'processed')
      ->findOrFail($id);
    return view('collector.waste-reports.show', compact('report'));
  }

  public function updateStatus(Request $request, WasteReport $report)
  {
    $report->update([
      'status' => $request->status
    ]);

    if ($request->ajax()) {
      return response()->json(['success' => true]);
    }

    return back()->with('success', 'Status laporan berhasil diperbarui.');
  }

  public function complete($id)
  {
    $report = WasteReport::where('status', 'processed')
      ->findOrFail($id);

    $report->update([
      'status' => 'completed',
      'completed_at' => now()
    ]);

    session()->flash('success', 'Laporan berhasil diselesaikan!');
    return redirect()->route('collector.waste-reports.index');
  }
}
