@extends('layouts.admin')

@section('header', 'Tambah Pengangkut Sampah')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
  <div class="bg-white rounded-xl shadow-2xl p-8">
    <form action="{{ route('admin.collectors.store') }}" method="POST" class="space-y-8">
      @csrf

      <!-- Personal Information Section -->
      <div class="space-y-6">
        <h2 class="text-xl font-semibold text-gray-800 border-l-4 border-green-500 pl-3">
          <i class="fas fa-user-circle mr-2 text-green-500"></i>
          Informasi Pribadi
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Nama Lengkap -->
          <div>
            <label for="name" class="block text-sm font-medium text-gray-600 mb-2">
              Nama Lengkap
            </label>
            <div class="relative">
              <input type="text" name="name" id="name" value="{{ old('name') }}"
                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                placeholder="Masukkan nama lengkap">
              <i class="fas fa-user absolute right-3 top-3.5 text-gray-400"></i>
            </div>
            @error('name')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
          </div>

          <!-- Email -->
          <div>
            <label for="email" class="block text-sm font-medium text-gray-600 mb-2">
              Email
            </label>
            <div class="relative">
              <input type="email" name="email" id="email" value="{{ old('email') }}"
                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                placeholder="contoh@email.com">
              <i class="fas fa-envelope absolute right-3 top-3.5 text-gray-400"></i>
            </div>
            @error('email')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
          </div>

          <!-- Nomor Telepon -->
          <div>
            <label for="phone_number" class="block text-sm font-medium text-gray-600 mb-2">
              Nomor Telepon
            </label>
            <div class="relative">
              <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number') }}"
                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                placeholder="0812-3456-7890">
              <i class="fas fa-phone-alt absolute right-3 top-3.5 text-gray-400"></i>
            </div>
            @error('phone_number')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
          </div>
        </div>
      </div>

      <!-- Vehicle Information Section -->
      <div class="space-y-6">
        <h2 class="text-xl font-semibold text-gray-800 border-l-4 border-green-500 pl-3">
          <i class="fas fa-truck-moving mr-2 text-green-500"></i>
          Informasi Kendaraan
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Nomor Kendaraan -->
          <div>
            <label for="vehicle_number" class="block text-sm font-medium text-gray-600 mb-2">
              Nomor Kendaraan
            </label>
            <div class="relative">
              <input type="text" name="vehicle_number" id="vehicle_number" value="{{ old('vehicle_number') }}"
                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                placeholder="B 1234 XYZ">
              <i class="fas fa-car absolute right-3 top-3.5 text-gray-400"></i>
            </div>
            @error('vehicle_number')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
          </div>

          <!-- Jenis Kendaraan -->
          <div>
            <label for="vehicle_type" class="block text-sm font-medium text-gray-600 mb-2">
              Jenis Kendaraan
            </label>
            <div class="relative">
              <select name="vehicle_type" id="vehicle_type"
                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 appearance-none transition-all">
                <option value="">Pilih Jenis Kendaraan</option>
                <option value="truck" {{ old('vehicle_type') == 'truck' ? 'selected' : '' }}>Truk</option>
                <option value="pickup" {{ old('vehicle_type') == 'pickup' ? 'selected' : '' }}>Pickup</option>
                <option value="motorcycle" {{ old('vehicle_type') == 'motorcycle' ? 'selected' : '' }}>Motor</option>
              </select>
              <i class="fas fa-chevron-down absolute right-3 top-3.5 text-gray-400 pointer-events-none"></i>
            </div>
            @error('vehicle_type')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
          </div>
        </div>
      </div>

      <!-- Account Information Section -->
      <div class="space-y-6">
        <h2 class="text-xl font-semibold text-gray-800 border-l-4 border-green-500 pl-3">
          <i class="fas fa-lock mr-2 text-green-500"></i>
          Informasi Akun
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Password -->
          <div>
            <label for="password" class="block text-sm font-medium text-gray-600 mb-2">
              Password
            </label>
            <div class="relative">
              <input type="password" name="password" id="password"
                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                placeholder="Minimal 8 karakter">
              <i class="fas fa-key absolute right-3 top-3.5 text-gray-400"></i>
            </div>
            @error('password')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
          </div>

          <!-- Konfirmasi Password -->
          <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-600 mb-2">
              Konfirmasi Password
            </label>
            <div class="relative">
              <input type="password" name="password_confirmation" id="password_confirmation"
                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                placeholder="Ulangi password">
              <i class="fas fa-redo absolute right-3 top-3.5 text-gray-400"></i>
            </div>
          </div>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="border-t pt-6">
        <div class="flex justify-end gap-3">
          <!-- batal -->
          <a href="{{ route('admin.collectors.index') }}"
            class="px-6 py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-lg shadow-md transition-all">
            Batal
          </a>
          <!-- simpan -->
          <button type="submit"
            class="px-6 py-2.5 bg-green-500 hover:bg-green-600 text-white rounded-lg shadow-md transition-all">
            <i class="fas fa-save mr-2"></i>Simpan Data
          </button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@push('styles')
<style>
  select::-ms-expand {
    display: none;
  }

  select {
    background-image: none;
  }
</style>
@endpush