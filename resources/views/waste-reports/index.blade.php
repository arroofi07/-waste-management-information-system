@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">Daftar Laporan Sampah</h2>
    <a href="{{ route('waste-reports.create') }}"
      class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
      Buat Laporan Baru
    </a>
  </div>

  <div class="bg-white shadow-md rounded-lg overflow-hidden">
    @if($reports->isEmpty())
    <div class="p-4 text-center text-gray-500">
      Belum ada laporan sampah. Mulai buat laporan sekarang!
    </div>
    @else
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Foto
            </th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Lokasi
            </th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Status
            </th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Tanggal
            </th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Aksi
            </th>
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
              <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $report->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $report->status === 'processed' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $report->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}">
                {{ ucfirst($report->status) }}
              </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
              {{ $report->created_at->format('d M Y H:i') }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
              @if($report->status === 'pending')
              <a href="{{ route('waste-reports.edit', $report) }}" class="text-blue-600 bg-blue-100 px-2 py-1 rounded-md hover:text-blue-900 mr-3">Edit</a>
              <form action="{{ route('waste-reports.destroy', $report) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 bg-red-100 px-2 py-1 rounded-md hover:text-red-900" onclick="return confirm('Yakin ingin menghapus laporan ini?')">
                  Hapus
                </button>
              </form>
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="px-6 py-4">
      {{ $reports->links() }}
    </div>
    @endif
  </div>
</div>
@endsection