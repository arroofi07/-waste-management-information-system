<?php

namespace App\Http\Controllers\Collector;

use App\Http\Controllers\Controller;
use App\Models\WasteReport;
use Illuminate\Http\Request;

class WasteReportController extends Controller
{
  public function index()
  {
    $reports = WasteReport::whereNull('collector_id')
      ->where('status', 'pending')
      ->orderBy('created_at', 'desc')
      ->paginate(10);

    return view('collector.waste-reports.index', compact('reports'));
  }

  public function myReports()
  {
    $userId = auth()->id();
    $reports = WasteReport::where('collector_id', $userId)
      ->whereIn('status', ['processed', 'completed'])
      ->orderBy('created_at', 'desc')
      ->paginate(10);

    return view('collector.waste-reports.my-reports', compact('reports'));
  }

  public function show($id)
  {
    $userId = auth()->id();
    $report = WasteReport::where('collector_id', $userId)
      ->findOrFail($id);
    return view('collector.waste-reports.show', compact('report'));
  }

  public function takeReport($id)
  {
    $userId = auth()->id();
    $report = WasteReport::whereNull('collector_id')
      ->where('status', 'pending')
      ->findOrFail($id);

    $report->update([
      'collector_id' => $userId,
      'collected_at' => now(),
      'status' => 'processed'
    ]);

    return redirect()
      ->route('collector.waste-reports.my-reports')
      ->with('success', 'Laporan berhasil diambil!');
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
    $report = WasteReport::where('collector_id', auth()->user()->id)
      ->where('status', 'processed')
      ->findOrFail($id);

    $report->update([
      'status' => 'completed',
      // 'completed_at' => now()
    ]);

    return redirect()
      ->route('collector.waste-reports.my-reports')
      ->with('success', 'Laporan berhasil diselesaikan!');
  }
}
