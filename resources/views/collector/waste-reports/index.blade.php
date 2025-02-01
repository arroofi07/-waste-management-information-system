@extends('layouts.app')

@section('content')
<!-- Modal Konfirmasi -->
<div id="confirmationModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
  <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
    <div class="mt-3 text-center">
      <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
      </div>
      <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Konfirmasi Pengangkutan</h3>
      <div class="mt-2 px-7 py-3">
        <p class="text-sm text-gray-500">Apakah Anda yakin sampah sudah diangkut?</p>
      </div>
      <div class="items-center px-4 py-3">
        <form id="completeForm" method="POST">
          @csrf
          <button type="submit" class="px-4 py-2 bg-green-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300 mb-2">
            Ya, Selesai
          </button>
        </form>
        <button onclick="closeModal()" class="px-4 py-2 bg-gray-400 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-300">
          Batal
        </button>
      </div>
    </div>
  </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
  <!-- Header Section -->
  <div class="mb-8 bg-white rounded-lg shadow-sm p-4 sm:p-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
      <div class="mb-4 sm:mb-0">
        <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Daftar Pengangkutan Sampah</h2>
        <p class="mt-1 text-sm text-gray-600">Kelola dan pantau status pengangkutan sampah</p>
      </div>
      <div class="flex items-center space-x-2 text-sm text-gray-600">
        <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
        </svg>
        <span>{{ now()->format('d F Y') }}</span>
      </div>
    </div>
  </div>

  @if($reports->isEmpty())
  <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
    <div class="flex">
      <div class="flex-shrink-0">
        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
        </svg>
      </div>
      <div class="ml-3">
        <h3 class="text-sm font-medium text-yellow-800">Belum Ada Laporan</h3>
        <p class="mt-1 text-sm text-yellow-700">Belum ada laporan sampah yang perlu diangkut saat ini.</p>
      </div>
    </div>
  </div>
  @else
  <!-- Card untuk Mobile View -->
  <div class="block sm:hidden space-y-4">
    @foreach($reports as $report)
    <div class="bg-white rounded-lg shadow-md p-4">
      <!-- <div class="flex justify-between items-start mb-3">
        <span class="text-sm font-medium text-gray-900">#{{ $loop->iteration }}</span>
        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
          {{ $report->waste_type }}
        </span>
      </div> -->

      <div class="space-y-2 mb-4">
        <div>
          <div class="text-sm font-medium text-gray-500">Lokasi:</div>
          <div class="text-sm text-gray-900">{{ $report->location }}</div>
        </div>

        <div>
          <div class="text-sm font-medium text-gray-500">Tanggal Laporan:</div>
          <div class="text-sm text-gray-900">{{ $report->created_at->format('d M Y H:i') }}</div>
        </div>
      </div>

      <div class="flex items-center justify-between">
        <a href="https://www.google.com/maps?q={{ $report->latitude }},{{ $report->longitude }}"
          target="_blank"
          class="inline-flex items-center text-blue-500">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
          </svg>
          <span class="ml-1 text-sm">Buka Maps</span>
        </a>

        <div class="flex space-x-2">
          <a href="{{ route('collector.waste-reports.show', $report->id) }}"
            class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
            Detail
          </a>

          <button onclick="showModal('/collector/waste-reports/{{ $report->id }}/complete')"
            class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            Selesai
          </button>
        </div>
      </div>
    </div>
    @endforeach
  </div>

  <!-- Table untuk Desktop View -->
  <div class="hidden sm:block">
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Maps</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Sampah</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @foreach($reports as $report)
            <tr class="hover:bg-gray-50">
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $loop->iteration }}</td>
              <td class="px-6 py-4">
                <div class="text-sm text-gray-900">{{ $report->location }}</div>
              </td>
              <td class="px-6 py-4">
                <a href="https://www.google.com/maps?q={{ $report->latitude }},{{ $report->longitude }}"
                  target="_blank"
                  class="text-blue-500 hover:text-blue-700 inline-flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                  </svg>
                </a>
              </td>
              <td class="px-6 py-4">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                  {{ $report->waste_type }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ $report->created_at->format('d M Y H:i') }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                <a href="{{ route('collector.waste-reports.show', $report->id) }}"
                  class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                  <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                  </svg>
                  Detail
                </a>
                <button onclick="showModal('/collector/waste-reports/{{ $report->id }}/complete')"
                  class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                  <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                  </svg>
                  Selesai
                </button>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
        {{ $reports->links() }}
      </div>
    </div>
  </div>
  @endif
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