@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-b py-12">
  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-xl shadow-xl overflow-hidden">
      <!-- Header Section -->
      <div class="bg-green-600 py-6 px-6">
        <h2 class="text-2xl font-bold text-white flex items-center gap-2">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
          </svg>
          Edit Laporan Sampah
        </h2>
        <p class="text-green-50 mt-2">Bantu jaga lingkungan dengan melaporkan sampah di sekitar Anda</p>
      </div>

      <form action="{{ route('waste-reports.update', $report) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-8">
        @csrf
        @method('PUT')

        <!-- Photo Upload Section -->
        <div class="space-y-4">
          <label class="block text-sm font-semibold text-gray-700 mb-2">
            Foto Sampah
          </label>
          <div class="flex flex-col items-center p-6 border-2 border-dashed border-green-200 rounded-lg bg-green-50 hover:bg-green-100 transition-colors">
            <!-- Display existing photo if available -->
            @if($report->photo)
            <img id="preview" src="{{ asset('storage/' . $report->photo) }}" class="w-48 h-48 object-cover rounded-lg shadow-md mb-4" alt="Existing Photo">
            @else
            <img id="preview" class="hidden w-48 h-48 object-cover rounded-lg shadow-md mb-4">
            @endif
            <!-- input foto sampah -->
            <input type="file"
              name="photo"
              id="photo"
              accept="image/*"
              class="block w-full text-sm text-gray-500
                    file:mr-4 file:py-2.5 file:px-4
                    file:rounded-full file:border-0
                    file:text-sm file:font-semibold
                    file:bg-green-600 file:text-white
                    hover:file:bg-green-700
                    transition-colors"
              onchange="previewImage(this)">
          </div>
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
              class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors flex items-center gap-2 whitespace-nowrap">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
              Lokasi Saya
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

        <button type="submit" class="w-full flex justify-center items-center gap-2 py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
          </svg>
          Update Laporan
        </button>
        <!-- batal -->
        <a href="{{ route('waste-reports.index') }}" class="w-full flex justify-center items-center gap-2 py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
          </svg>
          Batal
        </a>
      </form>
    </div>
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