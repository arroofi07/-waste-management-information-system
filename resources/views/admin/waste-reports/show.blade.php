@extends('layouts.adminw')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-8">
  <!-- Toast Notification -->
  <div x-data="{ show: false, message: '' }"
    x-on:status-updated.window="show = true; message = $event.detail; setTimeout(() => show = false, 3000)"
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform translate-y-2"
    x-transition:enter-end="opacity-100 transform translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 transform translate-y-0"
    x-transition:leave-end="opacity-0 transform translate-y-2"
    class="fixed top-4 right-4 z-50"
    style="display: none;">
    <div class="bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center">
      <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
      </svg>
      <span x-text="message"></span>
    </div>
  </div>

  <!-- Header responsif -->
  <div class="mb-6 sm:mb-8">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
      <div class="mb-4 sm:mb-0">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">Detail Laporan Sampah</h2>
        <!-- <p class="mt-1 text-sm text-gray-500">ID Laporan: #{{ $report->id }}</p> -->
      </div>
      <a href="{{ route('admin.waste-reports.index') }}"
        class="inline-flex items-center justify-center w-full sm:w-auto px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali ke daftar
      </a>
    </div>
  </div>

  <div class="bg-white shadow-lg rounded-xl overflow-hidden">
    <!-- Status Banner responsif -->
    <div class="px-4 sm:px-6 py-4 bg-gray-50 border-b border-gray-200">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
        <form x-data="{ 
          updateStatus(e) {
            const form = e.target.closest('form');
            const formData = new FormData(form);
            
            fetch(form.action, {
              method: 'POST',
              body: formData,
              headers: {
                'X-Requested-With': 'XMLHttpRequest',
              }
            })
            .then(response => response.json())
            .then(data => {
              window.dispatchEvent(new CustomEvent('status-updated', {
                detail: 'Status berhasil diperbarui'
              }));
            })
            .catch(error => {
              console.error('Error:', error);
            });
          }
        }"
          action="{{ route('admin.waste-reports.update-status', $report->id) }}"
          method="POST"
          class="w-full sm:w-auto">
          @csrf
          @method('PATCH')
          <select name="status"
            x-on:change="updateStatus($event)"
            class="w-full sm:w-auto h-10 rounded-md border-gray-300 text-base sm:text-sm focus:ring-blue-500 focus:border-blue-500
                    @if($report->status === 'pending') bg-yellow-100
                    @elseif($report->status === 'processed') bg-blue-100
                    @elseif($report->status === 'completed') bg-green-100
                    @else bg-gray-100 @endif">
            <option value="pending" {{ $report->status === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="processed" {{ $report->status === 'processed' ? 'selected' : '' }}>Diproses</option>
            <option value="completed" {{ $report->status === 'completed' ? 'selected' : '' }}>Selesai</option>
          </select>
        </form>
        <span class="text-sm text-gray-500">
          Dilaporkan pada {{ $report->created_at->format('d M Y H:i') }}
        </span>
      </div>
    </div>

    <div class="p-4 sm:p-6">
      <!-- Grid responsif -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8">
        <!-- Kolom Kiri: Informasi & Foto -->
        <div class="space-y-6 sm:space-y-8">
          <!-- Informasi Laporan -->
          <div class="bg-white p-4 sm:p-6 rounded-lg border border-gray-200">
            <h3 class="text-lg sm:text-xl font-semibold mb-4 sm:mb-6 text-gray-900">Informasi Laporan</h3>
            <div class="space-y-4 sm:space-y-6">
              <div>
                <label class="block text-sm font-medium text-gray-500">Lokasi</label>
                <span class="mt-1 block text-base text-gray-900">{{ $report->location }}</span>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-500">Deskripsi</label>
                <span class="mt-1 block text-base text-gray-900">{{ $report->description ?? 'Tidak ada deskripsi' }}</span>
              </div>
            </div>
          </div>

          <!-- Foto Laporan -->
          @if($report->photo)
          <div class="bg-white p-4 sm:p-6 rounded-lg border border-gray-200">
            <h3 class="text-lg sm:text-xl font-semibold mb-4 sm:mb-6 text-gray-900">Foto Laporan</h3>
            <div class="relative">
              <img src="{{ asset('storage/' . $report->photo) }}"
                alt="Foto Sampah"
                class="w-full h-auto rounded-lg shadow-sm hover:shadow-lg transition-shadow duration-200">
              <a href="{{ asset('storage/' . $report->photo) }}"
                target="_blank"
                class="absolute bottom-2 right-2 sm:bottom-4 sm:right-4 bg-white px-3 py-1.5 sm:px-4 sm:py-2 rounded-md shadow-sm hover:shadow-md transition-shadow duration-200 text-sm font-medium text-gray-700">
                Lihat Foto
              </a>
            </div>
          </div>
          @endif

          <!-- Informasi Pelapor -->
          <div class="bg-white p-4 sm:p-6 rounded-lg border border-gray-200">
            <h3 class="text-lg sm:text-xl font-semibold mb-4 sm:mb-6 text-gray-900">Informasi Pelapor</h3>
            <div class="space-y-4 sm:space-y-6">
              <div class="flex items-center">
                <!-- <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                  <span class="text-xl font-medium text-gray-600">{{ substr($report->user->name, 0, 1) }}</span>
                </div> -->
                <div class="ml-4">
                  <p class="text-base font-medium text-gray-900">{{ $report->user->name }}</p>
                  <p class="text-sm text-gray-500">{{ $report->user->email }}</p>
                </div>
              </div>
              @if($report->user->phone_number)
              <div>
                <label class="block text-sm font-medium text-gray-500">No. Telp</label>
                <span class="mt-1 block text-base text-gray-900">{{ $report->user->phone_number }}</span>
              </div>
              @endif
            </div>
          </div>
        </div>

        <!-- Kolom Kanan: Peta -->
        <div>
          @if($report->latitude && $report->longitude)
          <div class="lg:sticky lg:top-6">
            <div class="bg-white p-4 sm:p-6 rounded-lg border border-gray-200">
              <h3 class="text-lg sm:text-xl font-semibold mb-4 sm:mb-6 text-gray-900">Lokasi di Peta</h3>
              <div id="map" class="h-[300px] sm:h-[400px] lg:h-[600px] w-full rounded-lg shadow-sm"></div>
              <div class="mt-3 sm:mt-4 text-sm text-gray-500">
                Koordinat: {{ $report->latitude }}, {{ $report->longitude }}
              </div>
            </div>
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script>
  let map, marker;

  // Ambil data dari PHP dan konversi ke JavaScript
  const dbLocation = {
    latitude: Number('{{ $report->latitude }}'),
    longitude: Number('{{ $report->longitude }}')
  };

  function initMap() {
    console.log('Database location:', dbLocation); // Debug

    const initialPos = {
      lat: dbLocation.latitude,
      lng: dbLocation.longitude
    };

    map = L.map('map').setView([initialPos.lat, initialPos.lng], 15);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    placeMarker(initialPos);

    // Set nilai input hidden sesuai data dari database
    document.getElementById('latitude').value = dbLocation.latitude;
    document.getElementById('longitude').value = dbLocation.longitude;
  }

  function getCurrentLocation() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(
        function(position) {
          const pos = {
            lat: position.coords.latitude,
            lng: position.coords.longitude
          };

          map.setView([pos.lat, pos.lng], 15);
          placeMarker(pos);
          updateLocation(pos);
        },
        function(error) {
          alert('Error mendapatkan lokasi: ' + error.message);
        }
      );
    } else {
      alert('Browser tidak mendukung geolocation');
    }
  }

  function updateLocation(pos) {
    document.getElementById('latitude').value = pos.lat;
    document.getElementById('longitude').value = pos.lng;

    fetch(`https://nominatim.openstreetmap.org/reverse?lat=${pos.lat}&lon=${pos.lng}&format=json`)
      .then(response => response.json())
      .then(data => {
        document.getElementById('location').value = data.display_name;
      });
  }

  function placeMarker(pos) {
    if (marker) {
      map.removeLayer(marker);
    }
    marker = L.marker([pos.lat, pos.lng], {
      draggable: true
    }).addTo(map);

    marker.on('dragend', function() {
      const newPos = marker.getLatLng();
      updateLocation(newPos);
    });
  }

  function previewImage(input) {
    const preview = document.getElementById('preview');
    if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = function(e) {
        preview.src = e.target.result;
      }
      reader.readAsDataURL(input.files[0]);
    }
  }

  // Initialize map when page loads
  document.addEventListener('DOMContentLoaded', function() {
    console.log('Initializing map...'); // Debug
    initMap();
    document.getElementById('getLocationBtn').addEventListener('click', getCurrentLocation);
  });
</script>
@endpush
@endsection