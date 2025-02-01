@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
  <div class="max-w-6xl mx-auto px-4">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-bold text-gray-900">Detail Laporan</h1>
      <a href="{{ route('collector.waste-reports.my-reports') }}"
        class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali
      </a>
    </div>

    <!-- Main Content -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
      <div class="grid grid-cols-1 lg:grid-cols-2">
        <!-- Image Section -->
        <div class="relative h-[400px] lg:h-full">
          <img src="{{ Storage::url($report->photo) }}"
            class="w-full h-full object-cover"
            alt="Lokasi Sampah">
          <div class="absolute top-4 right-4">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
              {{ $report->status === 'processed' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
              <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="{{ $report->status === 'processed' ? 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z' : 'M5 13l4 4L19 7' }}" />
              </svg>
              {{ $report->status === 'processed' ? 'Dalam Proses' : 'Selesai' }}
            </span>
          </div>
        </div>

        <!-- Details Section -->
        <div class="p-6 lg:p-8">
          <!-- Location -->
          <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-2">Lokasi</h2>
            <p class="text-gray-700 mb-4">{{ $report->location }}</p>

            <!-- Map Links -->
            <div class="grid grid-cols-2 gap-3">
              <a href="https://www.google.com/maps/dir/?api=1&destination={{ $report->latitude }},{{ $report->longitude }}"
                target="_blank"
                class="inline-flex items-center justify-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                </svg>
                Google Maps
              </a>
              <a href="https://waze.com/ul?ll={{ $report->latitude }},{{ $report->longitude }}&navigate=yes"
                target="_blank"
                class="inline-flex items-center justify-center px-4 py-2 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                Waze
              </a>
            </div>
          </div>

          <!-- Description -->
          <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-2">Deskripsi</h2>
            <p class="text-gray-700">{{ $report->description }}</p>
          </div>

          <!-- Coordinates -->
          <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-2">Koordinat</h2>
            <div class="bg-gray-50 rounded-lg p-4">
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <p class="text-sm text-gray-500 mb-1">Latitude</p>
                  <p class="font-mono text-gray-700">{{ $report->latitude }}</p>
                </div>
                <div>
                  <p class="text-sm text-gray-500 mb-1">Longitude</p>
                  <p class="font-mono text-gray-700">{{ $report->longitude }}</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Timestamps -->
          <div class="mb-6">
            <div class="grid grid-cols-2 gap-4">
              <div>
                <p class="text-sm text-gray-500 mb-1">Dilaporkan</p>
                <p class="text-gray-700">{{ $report->created_at->format('d M Y H:i') }}</p>
              </div>
              <div>
                <p class="text-sm text-gray-500 mb-1">Diambil</p>
                <p class="text-gray-700">{{ $report->collected_at->format('d M Y H:i') }}</p>
              </div>
            </div>
          </div>

          <!-- Action Button -->
          @if($report->status === 'processed')
          <form action="{{ route('collector.waste-reports.complete', $report->id) }}"
            method="POST"
            class="mt-6">
            @csrf
            <button type="submit"
              class="w-full inline-flex items-center justify-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
              Selesaikan Laporan
            </button>
          </form>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
@endsection