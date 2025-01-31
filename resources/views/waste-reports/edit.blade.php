@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
  <div class="bg-white rounded-lg shadow-lg p-6">
    <h2 class="text-2xl font-bold mb-6">Edit Laporan Sampah</h2>

    <form action="{{ route('waste-reports.update', $report) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
      @csrf
      @method('PUT')

      <!-- Preview Foto -->
      <div class="space-y-2">
        <label class="block text-sm font-medium text-gray-700">Foto Sampah</label>
        <div class="mt-1 flex items-center">
          <img src="{{ asset('storage/' . $report->photo) }}" id="preview" class="w-32 h-32 object-cover rounded-lg">
        </div>
        <input type="file"
          name="photo"
          id="photo"
          accept="image/*"
          class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
          onchange="previewImage(this)">
        @error('photo')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- Lokasi -->
      <div class="space-y-2">
        <label class="block text-sm font-medium text-gray-700">Lokasi</label>
        <div class="flex gap-2">
          <input type="text"
            name="location"
            id="location"
            value="{{ old('location', $report->location) }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
            required
            readonly>
          <button type="button"
            id="getLocationBtn"
            class="mt-1 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
            Dapatkan Lokasi
          </button>
        </div>
        <input type="hidden" name="latitude" id="latitude" value="{{ $report->latitude }}">
        <input type="hidden" name="longitude" id="longitude" value="{{ $report->longitude }}">
        @error('location')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- Map -->
      <div id="map" style="height: 400px;" class="rounded-lg"></div>

      <!-- Deskripsi -->
      <div class="space-y-2">
        <label class="block text-sm font-medium text-gray-700">Deskripsi (Opsional)</label>
        <textarea name="description"
          rows="3"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description', $report->description) }}</textarea>
      </div>

      <div class="flex justify-between">
        <a href="{{ route('waste-reports.index') }}"
          class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
          Kembali
        </a>
        <button type="submit"
          class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
          Update Laporan
        </button>
      </div>
    </form>
  </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
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