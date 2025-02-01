<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <!-- Ganti Vite dengan CDN Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Leaflet CSS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
    crossorigin="" />

  <!-- Leaflet JavaScript -->
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
    crossorigin=""></script>

  <!-- Leaflet Marker Cluster CSS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" />

  <!-- Leaflet Marker Cluster JavaScript -->
  <script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>

  <!-- Leaflet Control Geocoder -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
  <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
</head>

<body class="bg-gray-100">
  <div class="flex h-screen">
    <!-- Sidebar -->
    <div class="bg-green-800 text-white w-64 flex-shrink-0">
      <div class="p-4">
        <h2 class="text-2xl font-bold">Dashboard</h2>
      </div>

      <nav class="mt-4">
        <!-- <a href="{{ route('admin.dashboard') }}"
          class="flex items-center px-4 py-3 {{ request()->routeIs('admin.dashboard') ? 'bg-green-700' : 'hover:bg-green-700' }}">
          <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
          </svg>
          Dashboard
        </a> -->

        <a href="{{ route('admin.collectors.index') }}"
          class="flex items-center px-4 py-3 {{ request()->routeIs('admin.collectors.*') ? 'bg-green-700' : 'hover:bg-green-700' }}">
          <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>
          Pengangkut Sampah
        </a>

        <a href="{{ route('admin.waste-reports.index') }}"
          class="flex items-center px-4 py-3 {{ request()->routeIs('admin.users.*') ? 'bg-green-700' : 'hover:bg-green-700' }}">
          <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
          </svg>
          Pelapor
        </a>

        <a href="{{ route('admin.statistics') }}"
          class="flex items-center px-4 py-3 {{ request()->routeIs('admin.statistics') ? 'bg-green-700' : 'hover:bg-green-700' }}">
          <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
          </svg>
          Statistik
        </a>

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}" class="mt-auto">
          @csrf
          <button type="button"
            onclick="showLogoutModal()"
            class="flex items-center px-4 py-3 w-full text-left hover:bg-green-700">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
            Logout
          </button>
        </form>
      </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
      <!-- Top Navigation -->
      <header class="bg-white shadow">
        <div class="px-4 py-3">
          <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">
              @yield('header', 'Dashboard')
            </h2>
            <div class="flex items-center">
              <span class="text-gray-600">{{ Auth::user()->name }}</span>
            </div>
          </div>
        </div>
      </header>

      <!-- Main Content Area -->
      <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
        <div class="container mx-auto px-6 py-8">
          @yield('content')
        </div>
      </main>
    </div>
  </div>

  <!-- Modal Konfirmasi Logout -->
  <div id="logoutModal"
    class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center">
    <div class="bg-white rounded-lg p-8 max-w-sm mx-auto">
      <h2 class="text-xl font-bold mb-4">Konfirmasi Logout</h2>
      <p class="text-gray-700 mb-6">Apakah Anda yakin ingin keluar dari aplikasi?</p>
      <div class="flex justify-end space-x-4">
        <button onclick="hideLogoutModal()"
          class="px-4 py-2 text-gray-600 hover:text-gray-800">
          Batal
        </button>
        <button onclick="document.querySelector('form[action=\'{{ route('logout') }}\']').submit()"
          class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
          Ya, Logout
        </button>
      </div>
    </div>
  </div>

  <!-- Script untuk Modal -->
  <script>
    function showLogoutModal() {
      document.getElementById('logoutModal').classList.remove('hidden');
      document.getElementById('logoutModal').classList.add('flex');
    }

    function hideLogoutModal() {
      document.getElementById('logoutModal').classList.remove('flex');
      document.getElementById('logoutModal').classList.add('hidden');
    }

    // Tutup modal jika user klik di luar modal
    document.getElementById('logoutModal').addEventListener('click', function(e) {
      if (e.target === this) {
        hideLogoutModal();
      }
    });

    // Tambahkan event listener untuk tombol Escape
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        hideLogoutModal();
      }
    });
  </script>

  <!-- Hapus Vite JS -->
  @stack('scripts')
  <!-- Alpine.js -->
  <script src="//unpkg.com/alpinejs" defer></script>
</body>

</html>