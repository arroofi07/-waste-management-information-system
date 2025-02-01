@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0 bg-gray-100">
  <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
    <div class="mb-6 text-center">
      <h2 class="text-2xl font-bold text-gray-900">
        Registrasi Pengangkut Sampah
      </h2>
      <p class="mt-2 text-sm text-gray-600">
        Daftar sebagai pengangkut sampah untuk mulai bekerja
      </p>
    </div>

    <form method="POST" action="{{ route('register.collector') }}">
      @csrf

      <!-- Nama -->
      <div class="mb-4">
        <label for="name" class="block text-sm font-medium text-gray-700">
          Nama Lengkap
        </label>
        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        @error('name')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <!-- Email -->
      <div class="mb-4">
        <label for="email" class="block text-sm font-medium text-gray-700">
          Email
        </label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        @error('email')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <!-- Nomor Telepon -->
      <div class="mb-4">
        <label for="phone_number" class="block text-sm font-medium text-gray-700">
          Nomor Telepon
        </label>
        <input id="phone_number" type="text" name="phone_number" value="{{ old('phone_number') }}" required
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        @error('phone_number')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <!-- Nomor Kendaraan -->
      <div class="mb-4">
        <label for="vehicle_number" class="block text-sm font-medium text-gray-700">
          Nomor Kendaraan
        </label>
        <input id="vehicle_number" type="text" name="vehicle_number" value="{{ old('vehicle_number') }}" required
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        @error('vehicle_number')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <!-- Jenis Kendaraan -->
      <div class="mb-4">
        <label for="vehicle_type" class="block text-sm font-medium text-gray-700">
          Jenis Kendaraan
        </label>
        <select id="vehicle_type" name="vehicle_type" required
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
          <option value="">Pilih Jenis Kendaraan</option>
          <option value="truck" {{ old('vehicle_type') == 'truck' ? 'selected' : '' }}>Truk</option>
          <option value="pickup" {{ old('vehicle_type') == 'pickup' ? 'selected' : '' }}>Pickup</option>
          <option value="motorcycle" {{ old('vehicle_type') == 'motorcycle' ? 'selected' : '' }}>Motor</option>
        </select>
        @error('vehicle_type')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <!-- Password -->
      <div class="mb-4">
        <label for="password" class="block text-sm font-medium text-gray-700">
          Password
        </label>
        <input id="password" type="password" name="password" required
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        @error('password')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <!-- Konfirmasi Password -->
      <div class="mb-6">
        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
          Konfirmasi Password
        </label>
        <input id="password_confirmation" type="password" name="password_confirmation" required
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
      </div>

      <div class="flex items-center justify-between mb-6">
        <button type="submit"
          class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
          Daftar
        </button>
      </div>

      <div class="text-center text-sm text-gray-600">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500">
          Login di sini
        </a>
      </div>
    </form>
  </div>
</div>
@endsection