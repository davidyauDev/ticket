<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport"
    content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>
    Mesa de Ayuda
  </title>
  <link rel="icon" type="image/svg+xml" href="{{ asset('images/logo-icon.svg') }}">
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>


</head>

<body
  x-data="{ page: 'ecommerce', 'loaded': true, 'darkMode': false, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }"
  x-init="darkMode = JSON.parse(localStorage.getItem('darkMode'));
$watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
  :class="{ 'dark bg-gray-900': darkMode === true }">
  <!-- ===== Preloader Start ===== -->
  <!-- ===== Preloader End ===== -->

  <!-- ===== Page Wrapper Start ===== -->
  <div class="flex h-screen overflow-hidden">
    <!-- ===== Sidebar Start ===== -->
    <x-layouts.app.sidebar />
    <!-- ===== Sidebar End ===== -->

    <!-- ===== Content Area Start ===== -->
    <div class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto">
      <!-- Small Device Overlay Start -->
      <x-layouts.overlay />
      <!-- Small Device Overlay End -->

      <!-- ===== Header Start ===== -->
      <x-layouts.app.header2 />
      <!-- ===== Header End ===== -->

      <!-- ===== Main Content Start ===== -->
      <main>
        {{ $slot }}
      </main>
      <!-- ===== Main Content End ===== -->
    </div>
    <!-- ===== Content Area End ===== -->
  </div>
  @fluxScripts
  <!-- ===== Page Wrapper End ===== -->
</body>

</html>
@vite(['resources/css/app.css', 'resources/js/app.js'])