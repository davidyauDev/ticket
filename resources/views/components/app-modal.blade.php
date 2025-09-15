@props(['id' => null, 'maxWidth' => 'max-w-xl'])

<div
    x-data="{ isModalOpen: @entangle($attributes->wire('model')) }"
    x-show="isModalOpen"
    class="fixed inset-0 flex items-center justify-center p-5 z-50"
>
    <!-- Fondo oscuro -->
    <div @click="isModalOpen = false"
         class="fixed inset-0 h-full w-full bg-gray-400/50 backdrop-blur-[32px]"></div>

    <!-- Caja modal -->
    <div @click.outside="isModalOpen = false"
         x-transition.scale.origin-center.duration.100ms
         {{ $attributes->merge(['class' => "relative w-full {$maxWidth} rounded-3xl bg-white p-6 dark:bg-gray-900 lg:p-10"]) }}>

        <!-- Botón cerrar -->
        <button @click="isModalOpen = false"
                class="absolute right-3 top-3 z-[999] flex h-9 w-9 items-center justify-center rounded-full bg-gray-100 text-gray-400 transition-colors hover:bg-gray-200 hover:text-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white sm:right-6 sm:top-6 sm:h-11 sm:w-11">
            <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24">
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M6.04 16.54c-.39.39-.39 1.02 0 1.41.39.39 1.02.39 1.41 0l4.55-4.55 4.54 4.55c.39.39 1.02.39 1.41 0 .39-.39.39-1.02 0-1.41L13.41 12l4.54-4.54c.39-.39.39-1.02 0-1.41-.39-.39-1.02-.39-1.41 0L12 10.59 7.46 6.05c-.39-.39-1.02-.39-1.41 0-.39.39-.39 1.02 0 1.41L10.59 12l-4.55 4.54z"/>
            </svg>
        </button>

        <!-- Contenido dinámico -->
        {{ $slot }}

    </div>
</div>
