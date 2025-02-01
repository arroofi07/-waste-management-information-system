@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br  via-white ">
  <!-- Header Section -->
  <div class="container mx-auto px-4 pt-8">
    <div class="max-w-6xl mx-auto">
      <div class="bg-gradient-to-r from-green-600 to-green-700 rounded-2xl shadow-xl overflow-hidden">
        <div class="px-6 py-8 md:px-10 md:py-12">
          <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="space-y-4">
              <div class="inline-flex items-center space-x-2 bg-green-500/20 rounded-full px-4 py-1">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <span class="text-white text-sm font-medium">Dashboard Tugas</span>
              </div>
              <h1 class="text-3xl md:text-4xl font-bold text-white">Tugas Saya</h1>
                            <p class="text-green-100 text-lg">Kelola dan pantau tugas pengangkutan sampah Anda</p>
            </div>
            <a href="{{ route('collector.waste-reports.index') }}"
              class="inline-flex items-center px-6 py-3 bg-white text-green-600 rounded-xl hover:bg-green-50 transition-all duration-200 font-semibold shadow-md hover:shadow-xl transform hover:-translate-y-1">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
              </svg>
              Ambil Tugas Baru
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Alert Messages -->
  @if(session('success'))
  <div class="container mx-auto px-4 mt-6">
    <div class="max-w-6xl mx-auto">
      <div class="bg-green-100 border-l-4 border-green-500 rounded-lg p-4 flex items-center shadow-md">
        <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <p class="text-green-700">{{ session('success') }}</p>
        <button type="button" class="ml-auto text-green-700 hover:text-green-900" data-bs-dismiss="alert">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
    </div>
  </div>
  @endif

  <!-- Task Grid -->
  <div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($reports as $report)
        <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
          <div class="flex flex-col md:flex-row h-full">
            <div class="md:w-2/5 h-48 md:h-auto relative">
              <img src="{{ Storage::url($report->photo) }}"
                class="w-full h-full object-cover"
                alt="Lokasi Sampah">
              <div class="absolute top-3 left-3">
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
            <div class="flex-1 p-6">
              <div class="flex items-start justify-between mb-4">
                <div class="flex items-center space-x-2">
                  <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                  </div>
                  <h3 class="font-semibold text-gray-900">{{ Str::limit($report->location, 30) }}</h3>
                </div>
                <span class="text-sm text-gray-500">{{ $report->collected_at->diffForHumans() }}</span>
              </div>

              <div class="space-y-3">
                <a href="{{ route('collector.waste-reports.show', $report->id) }}"
                  class="inline-flex items-center justify-center w-full px-4 py-2 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition-colors duration-200">
                  <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                  </svg>
                  Detail Tugas
                </a>

                @if($report->status === 'processed')
                <form action="{{ route('collector.waste-reports.complete', $report->id) }}"
                  method="POST"
                  onsubmit="return confirm('Apakah Anda yakin ingin menyelesaikan tugas ini?')">
                  @csrf
                  <button type="submit"
                    class="inline-flex items-center justify-center w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Selesaikan Tugas
                  </button>
                </form>
                @endif
              </div>
            </div>
          </div>
        </div>
        @empty
          <div class="col-span-2">
          <div class="bg-white rounded-xl shadow-md p-8 text-center">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
              <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Tugas</h3>
            <p class="text-gray-500 mb-6">Anda belum mengambil tugas pengangkutan sampah apapun.</p>
            <a href="{{ route('collector.waste-reports.index') }}"
              class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
              Cari Tugas Tersedia
            </a>
          </div>
        </div>
        @endforelse
      </div>

      <!-- Pagination -->
      @if($reports->hasPages())
      <div class="mt-8 flex justify-center">
        {{ $reports->links('pagination::tailwind') }}
      </div>
      @endif
    </div>
  </div>
</div>

<style>
  @keyframes slideIn {
    from {
      opacity: 0;
      transform: translateY(20px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .animate-slide-in {
    animation: slideIn 0.5s ease-out;
  }
</style>
@endsection