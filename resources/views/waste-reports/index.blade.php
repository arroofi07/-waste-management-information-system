@extends('layouts.app')
@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-green-50 py-8">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-center mb-8">
      <div class="mb-4 sm:mb-0">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Daftar Laporan Sampah</h1>
        <p class="mt-1 text-sm text-gray-600">Kelola laporan sampah Anda di sini</p>
      </div>
      <a href="{{ route('waste-reports.create') }}"
        class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-xl hover:bg-green-700 transition-colors duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Buat Laporan Baru
      </a>
    </div>

    <!-- Main Content -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
      @if($reports->isEmpty())
      <div class="p-12 text-center">
        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
          <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
          </svg>
        </div>
        <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Laporan</h3>
        <p class="text-gray-600 mb-6">Mulai buat laporan sampah pertama Anda sekarang!</p>
        <a href="{{ route('waste-reports.create') }}"
          class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-xl hover:bg-green-700 transition-colors duration-200">
          Buat Laporan Baru
        </a>
      </div>
      @else
      <!-- Mobile View -->
      <div class="block sm:hidden">
        <div class="divide-y divide-gray-200">
          @foreach($reports as $report)
          <div class="p-4 hover:bg-green-50 transition-colors duration-200">
            <div class="flex space-x-4">
              <div class="flex-shrink-0">
                @if($report->photo)
                <img src="{{ asset('storage/' . $report->photo) }}"
                  alt="Foto Sampah"
                  class="h-24 w-24 object-cover rounded-xl shadow-sm">
                @else
                <div class="h-24 w-24 bg-green-100 rounded-xl flex items-center justify-center">
                  <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                </div>
                @endif
              </div>
              <div class="flex-1 min-w-0">
                <div class="text-sm font-semibold text-gray-900 mb-1">{{ $report->location }}</div>
                @if($report->description)
                <p class="text-sm text-gray-600 mb-2 line-clamp-2">{{ $report->description }}</p>
                @endif
                <div class="flex items-center justify-between mb-2">
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                    {{ $report->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                    {{ $report->status === 'processed' ? 'bg-blue-100 text-blue-800' : '' }}
                    {{ $report->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}">
                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 8 8">
                      <circle cx="4" cy="4" r="3" />
                    </svg>
                    {{ ucfirst($report->status) }}
                  </span>
                  <time class="text-xs text-gray-500">{{ $report->created_at->format('d M Y H:i') }}</time>
                </div>
                @if($report->status === 'pending')
                <div class="flex space-x-2">
                  <a href="{{ route('waste-reports.edit', $report) }}"
                    class="flex-1 inline-flex justify-center items-center px-3 py-1.5 text-sm text-green-700 bg-green-100 rounded-lg hover:bg-green-200">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                  </a>
                  <form action="{{ route('waste-reports.destroy', $report) }}" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                      class="w-full inline-flex justify-center items-center px-3 py-1.5 text-sm text-red-700 bg-red-100 rounded-lg hover:bg-red-200"
                      onclick="return confirm('Yakin ingin menghapus laporan ini?')">
                      <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                      </svg>
                      Hapus
                    </button>
                  </form>
                </div>
                @endif
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>

      <!-- Desktop View -->
      <div class="hidden sm:block">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-green-50">
            <tr>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-green-800 uppercase tracking-wider">Foto</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-green-800 uppercase tracking-wider">Lokasi</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-green-800 uppercase tracking-wider">Status</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-green-800 uppercase tracking-wider">Tanggal</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-green-800 uppercase tracking-wider">Aksi</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @foreach($reports as $report)
            <tr class="hover:bg-green-50 transition-colors duration-200">
              <td class="px-6 py-4 whitespace-nowrap">
                @if($report->photo)
                <img src="{{ asset('storage/' . $report->photo) }}"
                  alt="Foto Sampah"
                  class="h-20 w-20 object-cover rounded-lg shadow-sm">
                @else
                <div class="h-20 w-20 bg-green-100 rounded-lg flex items-center justify-center">
                  <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                </div>
                @endif
              </td>
              <td class="px-6 py-4">
                <div class="text-sm font-medium text-gray-900">{{ $report->location }}</div>
                @if($report->description)
                <div class="text-sm text-gray-500 mt-1">{{ Str::limit($report->description, 100) }}</div>
                @endif
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                  {{ $report->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                  {{ $report->status === 'processed' ? 'bg-blue-100 text-blue-800' : '' }}
                  {{ $report->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}">
                  <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 8 8">
                    <circle cx="4" cy="4" r="3" />
                  </svg>
                  {{ ucfirst($report->status) }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ $report->created_at->format('d M Y H:i') }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                @if($report->status === 'pending')
                <div class="flex space-x-2">
                  <a href="{{ route('waste-reports.edit', $report) }}"
                    class="inline-flex items-center px-3 py-1.5 text-green-700 bg-green-100 rounded-lg hover:bg-green-200">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                  </a>
                  <form action="{{ route('waste-reports.destroy', $report) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                      class="inline-flex items-center px-3 py-1.5 text-red-700 bg-red-100 rounded-lg hover:bg-red-200"
                      onclick="return confirm('Yakin ingin menghapus laporan ini?')">
                      <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                      </svg>
                      Hapus
                    </button>
                  </form>
                </div>
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      @if($reports->hasPages())
      <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
        {{ $reports->links() }}
      </div>
      @endif
      @endif
    </div>
  </div>
</div>
@endsection
