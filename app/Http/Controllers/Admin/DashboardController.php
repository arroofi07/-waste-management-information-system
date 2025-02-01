<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WasteReport;

class DashboardController extends Controller
{
  public function index()
  {
    $totalReports = WasteReport::count();
    $totalCollectors = User::where('role', 'collector')->count();
    $totalWaste = 0;
    $recentReports = WasteReport::latest()->take(5)->get();
    $collectors = User::where('role', 'collector')->latest()->get();

    return view('admin.dashboard', compact(
      'totalReports',
      'totalCollectors',
      'totalWaste',
      'recentReports',
      'collectors'
    ));
  }
}
