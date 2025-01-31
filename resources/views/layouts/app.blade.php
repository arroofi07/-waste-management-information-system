<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ config('app.name', 'Sistem Pengelolaan Sampah') }}</title>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Styles -->
  @stack('styles')
</head>

<body class="bg-gray-100">
  <nav class="bg-blue-600 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16">
        <div class="flex items-center">
          <a href="/" class="text-white text-lg font-semibold">
            {{ config('app.name', 'Sistem Pengelolaan Sampah') }}
          </a>
        </div>

        <div class="flex items-center">
          @guest
          <a href="{{ route('login') }}" class="text-gray-100 hover:text-gray-200 px-3 py-2">
            Login
          </a>
          <a href="{{ route('register') }}" class="text-gray-100 hover:text-gray-200 px-3 py-2">
            Register
          </a>
          @else
          <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="text-gray-100 hover:text-gray-200 px-3 py-2">
              {{ Auth::user()->name }}
              <svg class="h-4 w-4 inline-block ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>

            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1">
              <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                  Logout
                </button>
              </form>
            </div>
          </div>
          @endguest
        </div>
      </div>
    </div>
  </nav>

  <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    @yield('content')
  </main>

  <!-- Alpine.js for dropdown functionality -->
  <script src="//unpkg.com/alpinejs" defer></script>

  <!-- Scripts -->
  @stack('scripts')
</body>

</html>