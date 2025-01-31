@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Manajemen Laporan Sampah</h2>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
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
                            Pelapor
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
                                        class="rounded-md border-gray-300 text-sm">
                                    <option value="pending" {{ $report->status === 'pending' ? 'selected' : '' }}>
                                        Pending
                                    </option>
                                    <option value="active" {{ $report->status === 'active' ? 'selected' : '' }}>
                                        Aktif
                                    </option>
                                    <option value="completed" {{ $report->status === 'completed' ? 'selected' : '' }}>
                                        Selesai
                                    </option>
                                </select>
                            </form>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $report->created_at->format('d M Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.waste-reports.show', $report->id) }}" 
                               class="text-blue-600 hover:text-blue-900 mr-3">
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
        <div class="px-6 py-4">
            {{ $reports->links() }}
        </div>
    </div>
</div>
@endsection