<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WasteReport;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
  public function index()
  {
    // Ambil data pelapor dari WasteReport
    $topReporters = WasteReport::with('user')
      ->select('user_id')
      ->selectRaw('COUNT(*) as total_reports')
      ->groupBy('user_id')
      ->orderByDesc('total_reports')
      ->limit(10)
      ->get()
      ->map(function ($report) {
        return [
          'name' => $report->user->name,
          'email' => $report->user->email,
          'total_reports' => $report->total_reports
        ];
      });

    // Debug
    \Log::info('Top Reporters:', $topReporters->toArray());

    // Ambil 10 collector dengan pengangkutan terbanyak
    $topCollectors = User::where('role', 'collector')
      ->withCount(['collections' => function ($query) {
        $query->where('status', 'completed');
      }])
      ->orderByDesc('collections_count')
      ->limit(10)
      ->get();

    // Data untuk grafik
    $chartData = $this->getMonthlyStats();

    return view('admin.statistics.index', compact(
      'topReporters',
      'topCollectors',
      'chartData'
    ));
  }

  private function getMonthlyStats()
  {
    // Ambil data 30 hari terakhir
    $startDate = Carbon::now()->subDays(29)->startOfDay();
    $endDate = Carbon::now()->endOfDay();

    // Data laporan per hari
    $reports = WasteReport::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
      ->whereBetween('created_at', [$startDate, $endDate])
      ->groupBy('date')
      ->get()
      ->pluck('total', 'date')
      ->toArray();

    // Data pengangkutan per hari (status completed)
    $collections = WasteReport::select(DB::raw('DATE(collected_at) as date'), DB::raw('count(*) as total'))
      ->where('status', 'completed')
      ->whereNotNull('collected_at')
      ->whereBetween('collected_at', [$startDate, $endDate])
      ->groupBy('date')
      ->get()
      ->pluck('total', 'date')
      ->toArray();

    // Generate labels dan data untuk 30 hari
    $labels = [];
    $reportData = [];
    $collectionData = [];

    for ($date = $startDate->copy(); $date <= $endDate; $date->addDay()) {
      $dateString = $date->format('Y-m-d');
      $labels[] = $date->format('d M');
      $reportData[] = $reports[$dateString] ?? 0;
      $collectionData[] = $collections[$dateString] ?? 0;
    }

    return [
      'labels' => $labels,
      'reports' => $reportData,
      'collections' => $collectionData
    ];
  }
}
