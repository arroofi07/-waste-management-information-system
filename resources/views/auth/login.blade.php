@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0 bg-gray-100">
  <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
    <div class="mb-6 text-center">
      <h2 class="text-2xl font-bold text-gray-900">
        Login
      </h2>
    </div>

    <form method="POST" action="{{ route('login') }}">
      @csrf
      <div class="rounded-md shadow-sm -space-y-px">
        <div>
          <label for="email" class="sr-only">Email</label>
          <input id="email" name="email" type="email" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm" placeholder="Email address">
          @error('email')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
          @enderror
        </div>
        <div>
          <label for="password" class="sr-only">Password</label>
          <input id="password" name="password" type="password" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm" placeholder="Password">
          @error('password')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
          @enderror
        </div>
      </div>

      <div class="flex items-center justify-between mb-4">
        <div class="flex items-center">
          <input type="checkbox" name="remember" id="remember" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
          <label for="remember" class="ml-2 block text-sm text-gray-700">Ingat Saya</label>
        </div>

        @if (Route::has('password.request'))
        <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:text-blue-500">
          Lupa Password?
        </a>
        @endif
      </div>

      <div class="mb-6">
        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
          Login
        </button>
      </div>
    </form>

    <div class="relative mb-6">
      <div class="absolute inset-0 flex items-center">
        <div class="w-full border-t border-gray-300"></div>
      </div>
      <div class="relative flex justify-center text-sm">
        <span class="bg-white px-2 text-gray-500">atau</span>
      </div>
    </div>

    <div class="space-y-4">
      <a href="{{ route('register') }}" class="w-full block text-center bg-gray-50 hover:bg-gray-100 text-gray-700 font-semibold py-2 px-4 rounded-md border border-gray-300">
        Daftar sebagai Pengguna
      </a>

      <a href="{{ route('register.collector') }}" class="w-full block text-center bg-green-50 hover:bg-green-100 text-green-700 font-semibold py-2 px-4 rounded-md border border-green-300">
        Daftar sebagai Pengangkut Sampah
      </a>
    </div>

    <div class="mt-6 text-center text-sm text-gray-600">
      Dengan mendaftar, Anda menyetujui syarat dan ketentuan yang berlaku
    </div>
  </div>
</div>
@endsection