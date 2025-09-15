<!doctype html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport"
    content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>Mesa de Ayuda</title>

  <link rel="icon" type="image/svg+xml" href="{{ asset('images/logo-icon.svg') }}">

  <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
  <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" media="print" onload="this.media='all'">

  @vite(['resources/css/app.css'])

  <link rel="preload" as="style" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" onload="this.onload=null;this.rel='stylesheet'">
  <noscript><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"></noscript>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/apexcharts" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js" defer></script>

</head>

<body
  x-data="{ page: 'ecommerce', loaded: true, darkMode: false, stickyMenu: false, sidebarToggle: false, scrollTop: false }"
  x-init="darkMode = JSON.parse(localStorage.getItem('darkMode'));
           $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
  :class="{ 'dark bg-gray-900': darkMode === true }">


  <div class="flex h-screen overflow-hidden">
    <x-layouts.app.sidebar />

    <div class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto">
      <x-layouts.overlay />
      <x-layouts.app.header />
      <main>
        {{ $slot }}
      </main>
    </div>
  </div>
  @fluxScripts
  @vite(['resources/js/app.js'])

</body>
</html>
