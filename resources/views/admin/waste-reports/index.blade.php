@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-xl sm:text-2xl font-bold">Manajemen Laporan Sampah</h2>
  </div>

  <div class="bg-white shadow-md rounded-lg overflow-hidden">
    <!-- Mobile View -->
    <div class="block sm:hidden">
      @foreach($reports as $report)
      <div class="p-4 border-b border-gray-200">
        <!-- Foto dan Info Utama -->
        <div class="flex space-x-4 mb-4">
          @if($report->photo)
          <img src="{{ asset('storage/' . $report->photo) }}"
            alt="Foto Sampah"
            class="h-20 w-20 object-cover rounded-lg flex-shrink-0">
          @else
          <div class="h-20 w-20 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
            <span class="text-gray-400 text-xs text-center">Tidak ada foto</span>
          </div>
          @endif

          <div class="flex-1">
            <div class="text-sm font-medium text-gray-900 mb-1">{{ $report->location }}</div>
            @if($report->description)
            <div class="text-xs text-gray-500">{{ $report->description }}</div>
            @endif
            <div class="mt-2 text-xs">
              <div class="text-gray-900">{{ $report->user->name }}</div>
              <div class="text-gray-500">{{ $report->user->email }}</div>
            </div>
          </div>
        </div>

        <!-- Status dan Tanggal -->
        <div class="mb-4">
          <form action="{{ route('admin.waste-reports.update-status', $report->id) }}"
            method="POST"
            class="mb-2">
            @csrf
            @method('PATCH')
            <select name="status"
              onchange="this.form.submit()"
              class="w-full h-10 px-3 rounded-md border-gray-300 text-base {{ 
                $report->status === 'pending' ? 'bg-yellow-100' : 
                ($report->status === 'processed' ? 'bg-green-100' : 
                ($report->status === 'completed' ? 'bg-blue-100' : 'bg-red-100')) 
              }}">
              <option value="pending" {{ $report->status === 'pending' ? 'selected' : '' }}>Pending</option>
              <option value="processed" {{ $report->status === 'processed' ? 'selected' : '' }}>Diproses</option>
              <option value="completed" {{ $report->status === 'completed' ? 'selected' : '' }}>Selesai</option>
            </select>
          </form>
          <div class="text-xs text-gray-500 mt-2">
            {{ $report->created_at->format('d M Y H:i') }}
          </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="flex justify-end space-x-3">
          <a href="{{ route('admin.waste-reports.show', $report->id) }}"
            class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 rounded-md text-base">
            Detail
          </a>
          @if($report->status === 'active')
          <a href="{{ route('admin.waste-reports.assign', $report->id) }}"
            class="inline-flex items-center px-4 py-2 bg-green-100 text-green-700 rounded-md text-base">
            Tugaskan
          </a>
          @endif
        </div>
      </div>
      @endforeach
    </div>

    <!-- Desktop View -->
    <div class="hidden sm:block overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-green-600 text-white">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Foto</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Lokasi</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Pelapor</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Status</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Tanggal</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Aksi</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @foreach($reports as $report)
          <tr>
            <td class="px-6 py-4 whitespace-nowrap">
              @if($report->photo)
              <img src="{{ asset('storage/' . $report->photo) }}"
                alt="Foto Sampah"
                class="h-20 w-20 object-cover rounded-lg">
              @else
              <span class="text-gray-400">Tidak ada foto</span>
              @endif
            </td>
            <td class="px-6 py-4">
              <div class="text-sm text-gray-900">{{ $report->location }}</div>
              @if($report->description)
              <div class="text-sm text-gray-500">{{ $report->description }}</div>
              @endif
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm text-gray-900">{{ $report->user->name }}</div>
              <div class="text-sm text-gray-500">{{ $report->user->email }}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <form action="{{ route('admin.waste-reports.update-status', $report->id) }}"
                method="POST"
                class="inline-flex">
                @csrf
                @method('PATCH')
                <select name="status"
                  onchange="this.form.submit()"
                  class="rounded-md border-gray-300 text-sm {{ 
                    $report->status === 'pending' ? 'bg-yellow-100' : 
                    ($report->status === 'processed' ? 'bg-green-100' : 
                    ($report->status === 'completed' ? 'bg-blue-100' : 'bg-red-100')) 
                  }}">
                  <option value="pending" {{ $report->status === 'pending' ? 'selected' : '' }}>Pending</option>
                  <option value="processed" {{ $report->status === 'processed' ? 'selected' : '' }}>Diproses</option>
                  <option value="completed" {{ $report->status === 'completed' ? 'selected' : '' }}>Selesai</option>
                </select>
              </form>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
              {{ $report->created_at->format('d M Y H:i') }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
              <a href="{{ route('admin.waste-reports.show', $report->id) }}"
                class="bg-green-100 text-green-700 rounded-md px-4 py-2">
                Detail
              </a>
              @if($report->status === 'active')
              <a href="{{ route('admin.waste-reports.assign', $report->id) }}"
                class="text-green-600 hover:text-green-900">
                Tugaskan
              </a>
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="px-6 py-4 border-t border-gray-200">
      {{ $reports->links() }}
    </div>
  </div>
</div>
@endsection