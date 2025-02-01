@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-green-50 to-white">
  <!-- Hero Section -->
  <div class="container mx-auto px-4 pt-16 pb-12 text-center">
    <div class="animate-fade-in-up">
      <div class="inline-block p-3 bg-green-100 rounded-full mb-6">
        <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
        </svg>
      </div>
      <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
        Pengangkutan Sampah
      </h1>
      <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
        Bergabung dalam misi menjaga lingkungan bersih dengan mengambil tugas pengangkutan sampah
      </p>
      <a href="{{ route('collector.waste-reports.my-reports') }}"
        class="inline-flex items-center px-8 py-4 text-lg font-semibold text-white bg-green-600 rounded-full hover:bg-green-700 transform hover:-translate-y-1 transition-all duration-200 shadow-lg hover:shadow-xl">
        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
        </svg>
        Lihat Tugas Saya
      </a>
    </div>
  </div>

  <!-- Main Content -->
  <div class="container mx-auto px-4 pb-16">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead>
            <tr class="bg-green-600 text-white">
              <th class="px-6 py-4 text-left">Foto</th>
              <th class="px-6 py-4 text-left">Lokasi</th>
              <!-- <th class="px-6 py-4 text-left">Deskripsi</th> -->
              <th class="px-6 py-4 text-left">Waktu</th>
              <th class="px-6 py-4 text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($reports as $report)
            <tr class="hover:bg-green-50 transition-colors duration-200">
              <td class="px-6 py-4">
                <div class="relative w-24 h-24 rounded-lg overflow-hidden">
                  <img src="{{ Storage::url($report->photo) }}"
                    class="w-full h-full object-cover transform hover:scale-110 transition-transform duration-200">
                </div>
              </td>
              <td class="px-6 py-4">
                <div class="flex items-center space-x-3">
                  <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                  </div>
                  <span class="font-medium text-gray-800">{{ $report->location }}</span>
                </div>
              </td>
              <!-- <td class="px-6 py-4">
                <p class="text-gray-600">{{ Str::limit($report->description, 100) }}</p>
              </td> -->
              <td class="px-6 py-4">
                <div class="flex items-center text-gray-500">
                  {{ $report->created_at->diffForHumans() }}
                </div>
              </td>
              <td class="px-6 py-4 text-center">
                <form action="{{ route('collector.waste-reports.take', $report->id) }}" method="POST">
                  @csrf
                  <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-full hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transform hover:-translate-y-1 transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 00-3 0m-6-3V11m0-5.5v-1a1.5 1.5 0 013 0v1m0 0V11m0-5.5a1.5 1.5 0 013 0v3m0 0V11" />
                    </svg>
                    Ambil Tugas
                  </button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="5" class="px-6 py-16 text-center">
                <div class="max-w-sm mx-auto">
                  <div class="rounded-full bg-green-100 p-6 w-24 h-24 mx-auto mb-6 flex items-center justify-center">
                    <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                  </div>
                  <h3 class="text-xl font-semibold text-gray-800 mb-2">Tidak Ada Tugas Tersedia</h3>
                  <p class="text-gray-600">Silakan periksa kembali nanti untuk tugas baru</p>
                </div>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      @if($reports->hasPages())
      <div class="px-6 py-4 border-t border-gray-200">
        {{ $reports->links('pagination::tailwind') }}
      </div>
      @endif
    </div>
  </div>
</div>

<style>
  @keyframes fade-in-up {
    0% {
      opacity: 0;
      transform: translateY(20px);
    }

    100% {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .animate-fade-in-up {
    animation: fade-in-up 0.6s ease-out;
  }
</style>
@endsection