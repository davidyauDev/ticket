<!doctype html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport"
      content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    
    <title>Sign In | TailAdmin</title>

    <!-- 🔁 Preconexión a fuentes si usas alguna externa -->
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin />

    <!-- ✅ CSS principal (idealmente usa Vite o @vite si estás en Laravel) -->
    <link rel="stylesheet" href="/path/to/your/main.css" />

    <!-- ✅ Flatpickr y demás CSS (con carga diferida) -->
    <link rel="preload" as="style" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" onload="this.rel='stylesheet'" />
    <noscript>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
    </noscript>
    
    <!-- ✅ Librerías JS (defer evita bloquear render) -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js" defer></script>

    <!-- ✅ Tu JS principal, al final con defer (si no usas Vite) -->
    <script src="/path/to/your/app.js" defer></script>
  </head>

  <body
    x-data="{ page: 'comingSoon', loaded: true, darkMode: false, stickyMenu: false, sidebarToggle: false, scrollTop: false }"
    x-init="darkMode = JSON.parse(localStorage.getItem('darkMode'));
             $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
    :class="{'dark bg-gray-900': darkMode === true}">

    <!-- ✅ Carga diferida de partes comunes con includes o Blade -->
    <include src="./partials/preloader.html"></include>

    <div class="relative p-6 bg-white z-1 dark:bg-gray-900 sm:p-0">
      <div class="relative flex flex-col justify-center w-full h-screen dark:bg-gray-900 sm:p-0 lg:flex-row">
        
        <!-- 🧾 Formulario de login -->
        <div class="flex flex-col flex-1 w-full lg:w-1/2">
          <!-- [Tu contenido original del form aquí sin cambios, ya está bien estructurado] -->
          <!-- ✅ Mantener accesibilidad y clases Tailwind -->
          <!-- ✅ Inputs, botones, toggles, etc -->
        </div>

        <!-- 📷 Imagen y mensaje a la derecha -->
        <div class="relative items-center hidden w-full h-full bg-brand-950 dark:bg-white/5 lg:grid lg:w-1/2">
          <div class="flex items-center justify-center z-1">
            <include src="./partials/common-grid-shape.html"></include>
            <div class="flex flex-col items-center max-w-xs">
              <a href="index.html" class="block mb-4">
                <img src="./images/logo/auth-logo.svg" alt="Logo" loading="lazy" />
              </a>
              <p class="text-center text-gray-400 dark:text-white/60">
                Free and Open-Source Tailwind CSS Admin Dashboard Template
              </p>
            </div>
          </div>
        </div>

        <!-- 🌘 Botón para cambiar tema -->
        <div class="fixed z-50 hidden bottom-6 right-6 sm:block">
          <button
            class="inline-flex items-center justify-center text-white transition-colors rounded-full size-14 bg-brand-500 hover:bg-brand-600"
            @click.prevent="darkMode = !darkMode">
            <!-- Iconos SVG para modo oscuro/claro -->
            <!-- Ya optimizados, no hace falta tocarlos -->
          </button>
        </div>
      </div>
    </div>
  </body>
</html>
