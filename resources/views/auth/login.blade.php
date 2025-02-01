@extends('layouts.auth')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-50 to-green-100 py-12 px-4 sm:px-6 lg:px-8">
  <div class="max-w-md w-full space-y-8 bg-white rounded-2xl shadow-xl p-8 border border-green-100">
    <!-- Header -->
    <div class="text-center">
      <div class="flex justify-center">
        <div class="bg-green-100 p-3 rounded-full">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
          </svg>
        </div>
      </div>
      <h2 class="mt-4 text-3xl font-extrabold text-gray-900">Selamat Datang Kembali</h2>
      <p class="mt-2 text-sm text-gray-600">Masuk ke akun Anda untuk melanjutkan</p>
    </div>

    <!-- Login Form -->
    <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-6">
      @csrf

      <!-- Email Input -->
      <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <div class="mt-1 relative rounded-md shadow-sm">
          <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
            </svg>
          </div>
          <input id="email" name="email" type="email" required
            class="pl-10 block w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500 transition-colors"
            placeholder="nama@email.com">
        </div>
        @error('email')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <!-- Password Input -->
      <div>
        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
        <div class="mt-1 relative rounded-md shadow-sm">
          <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
          </div>
          <input id="password" name="password" type="password" required
            class="pl-10 block w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500 transition-colors"
            placeholder="••••••••">
        </div>
        @error('password')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <!-- Remember Me & Forgot Password -->
      <div class="flex items-center justify-between">
        <div class="flex items-center">
          <input type="checkbox" name="remember" id="remember"
            class="h-4 w-4 rounded border-gray-300 text-green-600 focus:ring-green-500 transition-colors">
          <label for="remember" class="ml-2 block text-sm text-gray-700">Ingat Saya</label>
        </div>

        @if (Route::has('password.request'))
        <a href="{{ route('password.request') }}"
          class="text-sm font-medium text-green-600 hover:text-green-500 transition-colors">
          Lupa Password?
        </a>
        @endif
      </div>

      <!-- Login Button -->
      <button type="submit"
        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
        </svg>
        Masuk
      </button>

      <!-- Divider -->
      <div class="relative">
        <div class="absolute inset-0 flex items-center">
          <div class="w-full border-t border-gray-200"></div>
        </div>
        <div class="relative flex justify-center text-sm">
          <span class="px-2 bg-white text-gray-500">atau daftar sebagai</span>
        </div>
      </div>

      <!-- Registration Options -->
      <div class="space-y-4">
        <a href="{{ route('register') }}"
          class="w-full flex items-center justify-center px-4 py-3 border border-green-300 rounded-lg shadow-sm text-sm font-medium text-green-700 bg-white hover:bg-green-50 transition-colors">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
          </svg>
          Pengguna Baru
        </a>

        <a href="{{ route('register.collector') }}"
          class="w-full flex items-center justify-center px-4 py-3 border border-green-300 rounded-lg shadow-sm text-sm font-medium text-green-700 bg-green-50 hover:bg-green-100 transition-colors">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
          </svg>
          Pengangkut Sampah
        </a>
      </div>
    </form>

    <!-- Terms -->
    <p class="mt-6 text-center text-xs text-gray-600">
      Dengan melanjutkan, Anda menyetujui
      <a href="#" class="font-medium text-green-600 hover:text-green-500">Syarat dan Ketentuan</a>
      serta
      <a href="#" class="font-medium text-green-600 hover:text-green-500">Kebijakan Privasi</a>
      kami
    </p>
  </div>
</div>
@endsection