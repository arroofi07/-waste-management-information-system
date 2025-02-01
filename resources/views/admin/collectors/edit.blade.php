@extends('layouts.admin')

@section('header', 'Edit Pengangkut Sampah')

@section('content')
<div class="max-w-4xl mx-auto">
  <div class="bg-white rounded-lg shadow-lg p-6">
    <!-- Judul Form -->
    <h2 class="text-lg font-semibold text-gray-900 border-b pb-3 mb-4">
      Form Edit Pengangkut Sampah
    </h2>

    <form action="{{ route('admin.collectors.update', $collector->id) }}" method="POST" class="space-y-6">
      @csrf
      @method('PUT')

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Nama Lengkap -->
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
          <input type="text" name="name" id="name"
            value="{{ old('name', $collector->name) }}"
            class="mt-1 shadow-sm focus:ring-green-500 focus:border-green-500 block w-full sm:text-sm border-gray-300 rounded-md"
            required>
          @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <!-- Email -->
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
          <input type="email" name="email" id="email"
            value="{{ old('email', $collector->email) }}"
            class="mt-1 shadow-sm focus:ring-green-500 focus:border-green-500 block w-full sm:text-sm border-gray-300 rounded-md"
            required>
          @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <!-- Nomor Telepon -->
        <div>
          <label for="phone_number" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
          <input type="text" name="phone_number" id="phone_number"
            value="{{ old('phone_number', $collector->phone_number) }}"
            class="mt-1 shadow-sm focus:ring-green-500 focus:border-green-500 block w-full sm:text-sm border-gray-300 rounded-md"
            required>
          @error('phone_number') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <!-- Nomor Kendaraan -->
        <div>
          <label for="vehicle_number" class="block text-sm font-medium text-gray-700">Nomor Kendaraan</label>
          <input type="text" name="vehicle_number" id="vehicle_number"
            value="{{ old('vehicle_number', $collector->vehicle_number) }}"
            class="mt-1 shadow-sm focus:ring-green-500 focus:border-green-500 block w-full sm:text-sm border-gray-300 rounded-md"
            required>
          @error('vehicle_number') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <!-- Jenis Kendaraan -->
        <div class="col-span-2">
          <label for="vehicle_type" class="block text-sm font-medium text-gray-700">Jenis Kendaraan</label>
          <select name="vehicle_type" id="vehicle_type"
            class="mt-1 shadow-sm focus:ring-green-500 focus:border-green-500 block w-full sm:text-sm border-gray-300 rounded-md"
            required>
            <option value="">Pilih Jenis Kendaraan</option>
            <option value="truck" {{ old('vehicle_type', $collector->vehicle_type) == 'truck' ? 'selected' : '' }}>Truk</option>
            <option value="pickup" {{ old('vehicle_type', $collector->vehicle_type) == 'pickup' ? 'selected' : '' }}>Pickup</option>
            <option value="motorcycle" {{ old('vehicle_type', $collector->vehicle_type) == 'motorcycle' ? 'selected' : '' }}>Motor</option>
          </select>
          @error('vehicle_type') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <!-- Password Baru -->
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700">Password Baru (kosongkan jika tidak ingin mengganti)</label>
          <input type="password" name="password" id="password"
            class="mt-1 shadow-sm focus:ring-green-500 focus:border-green-500 block w-full sm:text-sm border-gray-300 rounded-md">
          @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <!-- Konfirmasi Password Baru -->
        <div>
          <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
          <input type="password" name="password_confirmation" id="password_confirmation"
            class="mt-1 shadow-sm focus:ring-green-500 focus:border-green-500 block w-full sm:text-sm border-gray-300 rounded-md">
        </div>
      </div>

      <!-- Tombol Submit dan Kembali -->
      <div class="flex justify-end space-x-3">
        <a href="{{ route('admin.collectors.index') }}"
          class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
          Kembali
        </a>
        <button type="submit"
          class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
          Simpan Perubahan
        </button>
      </div>
    </form>
  </div>
</div>
@endsection