@extends('layouts.admin')



@section('content')
<div class="bg-white rounded-lg shadow">
  <div class="p-6">
    <div class="flex justify-between items-center mb-6">
      <h3 class="text-lg font-semibold text-gray-700">Daftar Pengangkut Sampah</h3>
      <a href="{{ route('admin.collectors.create') }}"
        class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
        Tambah Pengangkut
      </a>
    </div>

    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Nama
            </th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Email
            </th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              No. Telepon
            </th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Kendaraan
            </th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Status
            </th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Aksi
            </th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @forelse($collectors as $collector)
          <tr>
            <td class="px-6 py-4 whitespace-nowrap">
              {{ $collector->name }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              {{ $collector->email }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              {{ $collector->phone_number }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              {{ ucfirst($collector->vehicle_type) }} - {{ $collector->vehicle_number }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $collector->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                {{ $collector->is_active ? 'Aktif' : 'Nonaktif' }}
              </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
              <div class="flex space-x-3">
                <a href="{{ route('admin.collectors.edit', $collector) }}"
                  class="text-indigo-600 hover:text-indigo-900">Edit</a>
                <form action="{{ route('admin.collectors.destroy', $collector) }}"
                  method="POST"
                  onsubmit="return confirm('Apakah Anda yakin?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="text-red-600 hover:text-red-900">
                    Hapus
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
              Belum ada data pengangkut sampah
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection