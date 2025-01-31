<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ config('app.name', 'Sistem Pengelolaan Sampah') }}</title>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Toastify CSS -->
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
  <!-- Toastify JS -->
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</head>

<body class="bg-gray-100">
  <main>
    @yield('content')
  </main>

  @if(session()->has('success'))
  <script>
    Toastify({
      text: "{{ session('success') }}",
      duration: 3000,
      gravity: "top",
      position: "right",
      style: {
        background: "#4CAF50",
      }
    }).showToast();
  </script>
  @endif

  @if(session()->has('error'))
  <script>
    Toastify({
      text: "{{ session('error') }}",
      duration: 3000,
      gravity: "top",
      position: "right",
      style: {
        background: "#EF4444",
      }
    }).showToast();
  </script>
  @endif
</body>

</html>