@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
  <div class="bg-white rounded-lg shadow-lg p-6">
    <h2 class="text-2xl font-bold mb-6">Laporkan Sampah</h2>

    <form action="{{ route('waste-reports.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
      @csrf

      <!-- Preview Foto -->
      <div class="space-y-2">
        <label class="block text-sm font-medium text-gray-700">
          Foto Sampah
        </label>
        <div class="mt-1 flex items-center">
          <img id="preview" class="hidden w-32 h-32 object-cover rounded-lg">
        </div>
        <input type="file"
          name="photo"
          id="photo"
          accept="image/*"
          class="block w-full text-sm text-gray-500
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-full file:border-0
                        file:text-sm file:font-semibold
                        file:bg-blue-50 file:text-blue-700
                        hover:file:bg-blue-100"
          required
          onchange="previewImage(this)">
        @error('photo')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- Lokasi -->
      <div class="space-y-2">
        <label class="block text-sm font-medium text-gray-700">
          Lokasi
        </label>
        <div class="flex gap-2">
          <input type="text"
            name="location"
            id="location"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
            required
            readonly>
          <button type="button"
            id="getLocationBtn"
            class="mt-1 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
            Dapatkan Lokasi
          </button>
        </div>
        <input type="hidden" name="latitude" id="latitude">
        <input type="hidden" name="longitude" id="longitude">
        @error('location')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- Map -->
      <div id="map" style="height: 400px;" class="rounded-lg"></div>

      <!-- Deskripsi -->
      <div class="space-y-2">
        <label class="block text-sm font-medium text-gray-700">
          Deskripsi (Opsional)
        </label>
        <textarea
          name="description"
          rows="3"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
      </div>

      <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
        Kirim Laporan
      </button>
    </form>
  </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
  #map {
    height: 400px;
    width: 100%;
  }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
  let map, marker;

  function initMap() {
    console.log('Initializing map...');
    // Default ke Jakarta
    map = L.map('map').setView([-6.200000, 106.816666], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Tambahkan click event ke map
    map.on('click', function(e) {
      const pos = e.latlng;
      placeMarker(pos);
      updateLocation(pos);
    });
  }

  function getCurrentLocation() {
    if (!navigator.geolocation) {
      alert('Browser Anda tidak mendukung geolocation');
      return;
    }

    const options = {
      enableHighAccuracy: true,
      timeout: 10000,
      maximumAge: 0
    };

    navigator.geolocation.getCurrentPosition(
      // Success callback
      function(position) {
        const pos = {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        };

        map.setView([pos.lat, pos.lng], 15);
        placeMarker(pos);
        updateLocation(pos);
      },
      // Error callback
      function(error) {
        let message = 'Gagal mendapatkan lokasi. ';
        switch (error.code) {
          case error.PERMISSION_DENIED:
            message += 'Mohon izinkan akses lokasi di browser Anda.';
            break;
          case error.POSITION_UNAVAILABLE:
            message += 'Coba aktifkan GPS atau gunakan browser lain.';
            break;
          case error.TIMEOUT:
            message += 'Permintaan lokasi timeout. Coba lagi.';
            break;
          default:
            message += 'Error tidak dikenal.';
        }
        alert(message);
        console.error('Geolocation error:', error);
      },
      options
    );
  }

  function updateLocation(pos) {
    document.getElementById('latitude').value = pos.lat;
    document.getElementById('longitude').value = pos.lng;

    fetch(`https://nominatim.openstreetmap.org/reverse?lat=${pos.lat}&lon=${pos.lng}&format=json`)
      .then(response => response.json())
      .then(data => {
        document.getElementById('location').value = data.display_name;
      })
      .catch(error => {
        console.error('Error getting address:', error);
        document.getElementById('location').value = `${pos.lat}, ${pos.lng}`;
      });
  }

  function placeMarker(pos) {
    if (marker) {
      map.removeLayer(marker);
    }
    marker = L.marker([pos.lat, pos.lng], {
      draggable: true
    }).addTo(map);

    // Update lokasi saat marker di-drag
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
        preview.classList.remove('hidden');
      }
      reader.readAsDataURL(input.files[0]);
    }
  }

  // Initialize
  document.addEventListener('DOMContentLoaded', function() {
    initMap();
    document.getElementById('getLocationBtn').addEventListener('click', getCurrentLocation);
  });
</script>
@endpush
@endsection