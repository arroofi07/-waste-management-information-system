@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
  <!-- Header dengan Breadcrumb -->
  <div class="mb-8 flex justify-between items-center">
    <div>
      <h2 class="text-2xl font-bold text-gray-900">Detail Laporan Sampah</h2>
      <div class="mt-1 flex items-center text-sm text-gray-500">
        <a href="{{ route('collector.waste-reports.index') }}" class="hover:text-blue-500">Daftar Laporan</a>
        <svg class="mx-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
        </svg>
        <span>Detail Laporan #{{ $report->id }}</span>
      </div>
    </div>
  </div>

  <div class="bg-white shadow-lg rounded-lg overflow-hidden">
    <!-- Status Banner -->
    <div class="bg-blue-500 px-6 py-4">
      <div class="flex items-center">
        <div class="flex-shrink-0">
          <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
          </svg>
        </div>
        <div class="ml-3">
          <h3 class="text-lg font-medium text-white">Laporan Sampah </h3>
          <p class="text-blue-100">Dilaporkan pada {{ $report->created_at->format('d M Y H:i') }}</p>
        </div>
      </div>
    </div>

    <div class="p-6">
      <!-- Grid Layout untuk Informasi -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Informasi Laporan -->
        <div class="bg-gray-50 p-6 rounded-lg">
          <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
            <svg class="h-5 w-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Informasi Laporan
          </h3>
          <dl class="space-y-4">
            <div>
              <dt class="text-sm font-medium text-gray-500">Status</dt>
              <dd class="mt-1">
                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                  Diproses
                </span>
              </dd>
            </div>
            <div>
              <dt class="text-sm font-medium text-gray-500">Jenis Sampah</dt>
              <dd class="mt-1 text-sm text-gray-900">{{ $report->waste_type }}</dd>
            </div>
          </dl>
        </div>

        <!-- Informasi Lokasi -->
        <div class="bg-gray-50 p-6 rounded-lg">
          <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
            <svg class="h-5 w-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            Lokasi
          </h3>
          <dl class="space-y-4">
            <div>
              <dt class="text-sm font-medium text-gray-500">Alamat Lengkap</dt>
              <dd class="mt-1 text-sm text-gray-900">{{ $report->location }}</dd>
            </div>
            <div>
              <dt class="text-sm font-medium text-gray-500">Petunjuk Maps</dt>
              <dd class="mt-1">
                <a href="https://www.google.com/maps?q={{ $report->latitude }},{{ $report->longitude }}"
                  target="_blank"
                  class="inline-flex items-center px-4 py-2 border border-blue-500 text-sm font-medium rounded-md text-blue-500 hover:bg-blue-50">
                  <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                  </svg>
                  Buka di Google Maps
                </a>
              </dd>
            </div>
          </dl>
        </div>
      </div>

      <!-- Foto Sampah -->
      <div class="mt-8">
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
          <svg class="h-5 w-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
          </svg>
          Foto Sampah
        </h3>
        <div class="bg-gray-50 p-6 rounded-lg">
          @if($report->photo)
          <img src="{{ asset('storage/' . $report->photo) }}"
            alt="Foto Sampah"
            class="rounded-lg shadow-md max-w-full h-auto">
          @else
          <div class="text-center py-8">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <p class="mt-2 text-sm text-gray-500">Tidak ada foto yang dilampirkan</p>
          </div>
          @endif
        </div>
      </div>

      <!-- Tombol Aksi -->
      <div class="mt-8 flex justify-end">
        <button onclick="showModal('/collector/waste-reports/{{ $report->id }}/complete')"
          class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
          <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
          </svg>
          Selesaikan Pengangkutan
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Konfirmasi -->
<div id="confirmationModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
  <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
    <div class="mt-3 text-center">
      <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
      </div>
      <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Konfirmasi Pengangkutan</h3>
      <div class="mt-2 px-7 py-3">
        <p class="text-sm text-gray-500">Apakah Anda yakin sampah sudah diangkut?</p>
      </div>
      <div class="items-center px-4 py-3">
        <form id="completeForm" method="POST">
          @csrf
          <button type="submit"
            class="w-full px-4 py-2 bg-green-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300 mb-2">
            Ya, Selesai
          </button>
        </form>
        <button onclick="closeModal()"
          class="w-full px-4 py-2 bg-gray-400 text-white text-base font-medium rounded-md shadow-sm hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-300">
          Batal
        </button>
      </div>
    </div>
  </div>
</div>

<script>
  function showModal(formAction) {
    document.getElementById('confirmationModal').classList.remove('hidden');
    document.getElementById('completeForm').action = formAction;
  }

  function closeModal() {
    document.getElementById('confirmationModal').classList.add('hidden');
  }

  window.onclick = function(event) {
    let modal = document.getElementById('confirmationModal');
    if (event.target == modal) {
      closeModal();
    }
  }
</script>
@endsection