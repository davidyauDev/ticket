<div>
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <!-- Breadcrumb -->
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                WhatsApp
            </h2>
            <nav>
                <ol class="flex items-center gap-2">
                    <li>
                        <a class="font-medium" href="{{ route('tickets.dashboard') }}" wire:navigate>Dashboard /</a>
                    </li>
                    <li class="font-medium text-primary">WhatsApp</li>
                </ol>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
            
            <!-- Loading Animation para crearSesion con mejor UX/UI -->
            <div wire:loading.flex wire:target="crearSesion,nuevaSesion" class="fixed inset-0 bg-black/30 backdrop-blur-sm z-50 flex items-center justify-center animate-fade-in">
                <div class="bg-white/95 backdrop-blur-lg rounded-2xl p-8 max-w-md mx-4 text-center shadow-2xl border border-white/20 animate-scale-in">
                    <!-- WhatsApp Logo Animado con mejor diseño -->
                    <div class="mb-8 relative">
                        <!-- Círculo de fondo suave -->
                        <div class="absolute inset-0 w-28 h-28 bg-gradient-to-br from-green-400/20 to-green-600/20 rounded-full mx-auto animate-pulse"></div>
                        
                        <!-- Logo principal -->
                        <div class="relative z-10 animate-float">
                            <svg width="80" height="80" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="text-green-500 mx-auto drop-shadow-lg">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.465 3.488" fill="currentColor"/>
                            </svg>
                        </div>
                        
                        <!-- Anillo giratorio elegante -->
                        <div class="absolute inset-0 w-28 h-28 mx-auto animate-spin-slow">
                            <div class="w-full h-full border-2 border-transparent border-t-green-400 border-r-green-300 rounded-full opacity-60"></div>
                        </div>
                        
                        <!-- Ondas de pulso -->
                        <div class="absolute inset-0 w-36 h-36 mx-auto animate-ping-slow opacity-30">
                            <div class="w-full h-full border border-green-400 rounded-full"></div>
                        </div>
                    </div>

                    <!-- Texto elegante -->
                    <h3 class="text-2xl font-semibold text-gray-800 mb-3 animate-text-shine">
                        Conectando WhatsApp
                    </h3>
                    <p class="text-gray-600 mb-6 text-sm">Estableciendo conexión segura...</p>
                    
                    <!-- Barra de progreso moderna -->
                    <div class="w-full bg-gray-200/50 rounded-full h-2 mb-6 overflow-hidden">
                        <div class="bg-gradient-to-r from-green-400 via-green-500 to-green-600 h-full rounded-full shadow-lg animate-progress-glow" style="width: 0%; animation: progressBar 7s ease-in-out forwards;"></div>
                    </div>

                    <!-- Pasos del proceso con mejor diseño -->
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center justify-start step-animation bg-gray-50/50 rounded-lg p-3" style="animation-delay: 0s;">
                            <div class="w-2 h-2 bg-green-500 rounded-full mr-3 animate-pulse shadow-green-500/50 shadow-lg"></div>
                            <span class="text-gray-700 font-medium">Inicializando sesión</span>
                            <div class="ml-auto">
                                <div class="w-4 h-4 border border-green-400 border-t-transparent rounded-full animate-spin"></div>
                            </div>
                        </div>
                        <div class="flex items-center justify-start step-animation bg-gray-50/50 rounded-lg p-3" style="animation-delay: 2s;">
                            <div class="w-2 h-2 bg-green-500 rounded-full mr-3 animate-pulse shadow-green-500/50 shadow-lg"></div>
                            <span class="text-gray-700 font-medium">Configurando cliente</span>
                            <div class="ml-auto">
                                <div class="w-4 h-4 border border-green-400 border-t-transparent rounded-full animate-spin"></div>
                            </div>
                        </div>
                        <div class="flex items-center justify-start step-animation bg-gray-50/50 rounded-lg p-3" style="animation-delay: 4s;">
                            <div class="w-2 h-2 bg-green-500 rounded-full mr-3 animate-pulse shadow-green-500/50 shadow-lg"></div>
                            <span class="text-gray-700 font-medium">Generando código QR</span>
                            <div class="ml-auto">
                                <div class="w-4 h-4 border border-green-400 border-t-transparent rounded-full animate-spin"></div>
                            </div>
                        </div>
                        <div class="flex items-center justify-start step-animation bg-green-50/70 rounded-lg p-3" style="animation-delay: 6s;">
                            <div class="w-2 h-2 bg-green-600 rounded-full mr-3 animate-bounce shadow-green-600/50 shadow-lg"></div>
                            <span class="text-green-700 font-semibold">¡Casi listo!</span>
                            <div class="ml-auto">
                                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Tiempo estimado elegante -->
                    <div class="mt-6 flex items-center justify-center text-xs text-gray-500">
                        <svg class="w-4 h-4 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="m12 6 0 6 4 4"></path>
                        </svg>
                        <span>Tiempo estimado: ~7 segundos</span>
                    </div>
                </div>
            </div>

            <!-- Loading Animation para regenerarQR con diseño mejorado -->
            <div wire:loading.flex wire:target="regenerarQR" class="fixed inset-0 bg-black/20 backdrop-blur-sm z-50 flex items-center justify-center animate-fade-in">
                <div class="bg-white/95 backdrop-blur-lg rounded-2xl p-8 max-w-sm mx-4 text-center shadow-2xl border border-white/20 animate-scale-in">
                    <!-- QR Icon con diseño moderno -->
                    <div class="mb-6 relative">
                        <!-- Fondo circular suave -->
                        <div class="absolute inset-0 w-24 h-24 bg-gradient-to-br from-blue-400/20 to-purple-500/20 rounded-full mx-auto animate-pulse"></div>
                        
                        <!-- QR Icon principal -->
                        <div class="relative z-10 animate-float">
                            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="text-blue-500 mx-auto drop-shadow-lg">
                                <rect x="3" y="3" width="8" height="8" rx="1.5" stroke="currentColor" stroke-width="2" fill="none"/>
                                <rect x="13" y="3" width="8" height="8" rx="1.5" stroke="currentColor" stroke-width="2" fill="none"/>
                                <rect x="3" y="13" width="8" height="8" rx="1.5" stroke="currentColor" stroke-width="2" fill="none"/>
                                <rect x="5" y="5" width="4" height="4" rx="0.5" fill="currentColor"/>
                                <rect x="15" y="5" width="4" height="4" rx="0.5" fill="currentColor"/>
                                <rect x="5" y="15" width="4" height="4" rx="0.5" fill="currentColor"/>
                                <rect x="13" y="13" width="2" height="2" rx="0.5" fill="currentColor"/>
                                <rect x="17" y="13" width="2" height="2" rx="0.5" fill="currentColor"/>
                                <rect x="15" y="15" width="2" height="2" rx="0.5" fill="currentColor"/>
                                <rect x="19" y="15" width="2" height="2" rx="0.5" fill="currentColor"/>
                                <rect x="13" y="17" width="2" height="2" rx="0.5" fill="currentColor"/>
                                <rect x="17" y="19" width="2" height="2" rx="0.5" fill="currentColor"/>
                            </svg>
                        </div>
                        
                        <!-- Anillo giratorio -->
                        <div class="absolute inset-0 w-24 h-24 mx-auto animate-spin-slow">
                            <div class="w-full h-full border-2 border-transparent border-t-blue-400 border-r-purple-400 rounded-full opacity-60"></div>
                        </div>
                    </div>

                    <!-- Texto con gradiente -->
                    <h3 class="text-xl font-semibold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-3">
                        🔄 Regenerando QR
                    </h3>
                    
                    <!-- Barra de progreso rápida -->
                    <div class="w-full bg-gray-200/50 rounded-full h-2 mb-4 overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-400 via-purple-500 to-blue-600 h-full rounded-full shadow-lg animate-progress-glow" style="width: 0%; animation: progressBarFast 3s ease-in-out forwards;"></div>
                    </div>

                    <!-- Mensaje elegante -->
                    <p class="text-sm text-gray-600 flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2 animate-pulse text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"></path>
                        </svg>
                        Usando sesión existente...
                    </p>
                </div>
            </div>

            <!-- Loading Animation para enviarMensajePrueba -->
            <div wire:loading.flex wire:target="enviarMensajePrueba" class="fixed inset-0 bg-black/20 backdrop-blur-sm z-50 flex items-center justify-center animate-fade-in">
                <div class="bg-white/95 backdrop-blur-lg rounded-2xl p-8 max-w-sm mx-4 text-center shadow-2xl border border-white/20 animate-scale-in">
                    <!-- Message Icon -->
                    <div class="mb-6 relative">
                        <div class="absolute inset-0 w-24 h-24 bg-gradient-to-br from-green-400/20 to-blue-500/20 rounded-full mx-auto animate-pulse"></div>
                        <div class="relative z-10 animate-float">
                            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="text-green-500 mx-auto drop-shadow-lg">
                                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div class="absolute inset-0 w-24 h-24 mx-auto animate-spin-slow">
                            <div class="w-full h-full border-2 border-transparent border-t-green-400 border-r-blue-400 rounded-full opacity-60"></div>
                        </div>
                    </div>

                    <h3 class="text-xl font-semibold bg-gradient-to-r from-green-600 to-blue-600 bg-clip-text text-transparent mb-3">
                        📤 Enviando Mensaje
                    </h3>
                    
                    <div class="w-full bg-gray-200/50 rounded-full h-2 mb-4 overflow-hidden">
                        <div class="bg-gradient-to-r from-green-400 via-blue-500 to-green-600 h-full rounded-full shadow-lg animate-progress-glow" style="width: 0%; animation: progressBarFast 2s ease-in-out forwards;"></div>
                    </div>

                    <p class="text-sm text-gray-600 flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2 animate-bounce text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                        </svg>
                        Enviando a 51915141721...
                    </p>
                </div>
            </div>
                @if (!$qrCodeSvg && !$sessionGuardada)
                    <!-- Estado inicial - Bienvenida -->
                    <div class="flex flex-col items-center justify-center py-20">
                        <!-- WhatsApp Icon -->
                        <div class="mb-6 transform hover:scale-110 transition-transform duration-300">
                            <svg width="120" height="120" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="text-green-500">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.465 3.488" fill="currentColor"/>
                            </svg>
                        </div>

                        <!-- Greeting Message -->
                        <div class="text-center mb-8">
                            <h1 class="text-5xl font-bold text-green-600 mb-4 animate-fade-in-up">Bienvenido al módulo de WhatsApp</h1>
                            <p class="text-xl text-gray-600 dark:text-gray-400 mb-8">
                                Crea una nueva sesión para comenzar a usar WhatsApp
                            </p>
                        </div>

                        <!-- Botón principal mejorado -->
                        <button 
                            wire:click="crearSesion" 
                            class="btn-glow hover-lift bg-gradient-to-r from-green-500 via-green-600 to-green-700 hover:from-green-600 hover:via-green-700 hover:to-green-800 text-white font-semibold py-4 px-8 rounded-2xl shadow-xl transform transition-all duration-300 flex items-center space-x-3 relative overflow-hidden group"
                            wire:loading.attr="disabled"
                            wire:loading.target="crearSesion,nuevaSesion"
                        >
                            <!-- Icono animado -->
                            <div class="relative">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="text-white group-hover:animate-pulse">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.465 3.488" fill="currentColor"/>
                                </svg>
                            </div>
                            <span class="text-lg">Crear Nueva Sesión de WhatsApp</span>
                            
                            <!-- Efecto de brillo en hover -->
                            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent transform -skew-x-12 translate-x-full group-hover:translate-x-[-100%] transition-transform duration-700"></div>
                        </button>

                        <!-- Información adicional -->
                        <div class="mt-8 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-6 max-w-2xl">
                            <h3 class="text-lg font-semibold text-green-800 dark:text-green-200 mb-3">
                                ¿Cómo funciona?
                            </h3>
                            <ul class="text-green-700 dark:text-green-300 space-y-2 text-left">
                                <li class="flex items-center">
                                    <span class="w-2 h-2 bg-green-500 rounded-full mr-3"></span>
                                    Haz clic en "Crear Nueva Sesión"
                                </li>
                                <li class="flex items-center">
                                    <span class="w-2 h-2 bg-green-500 rounded-full mr-3"></span>
                                    Espera a que se genere el código QR
                                </li>
                                <li class="flex items-center">
                                    <span class="w-2 h-2 bg-green-500 rounded-full mr-3"></span>
                                    Escanea el código con WhatsApp
                                </li>
                                <li class="flex items-center">
                                    <span class="w-2 h-2 bg-green-500 rounded-full mr-3"></span>
                                    ¡Listo para usar!
                                </li>
                            </ul>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Mensaje del backend -->
            @if ($apiResponse)
                <div class="mt-6 p-4 bg-gradient-to-r from-blue-50 to-green-50 border-l-4 border-green-500 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-gray-800 font-medium">{{ $apiResponse }}</p>
                    </div>
                </div>
            @endif

            <!-- Mostrar QR con diseño mejorado -->
            @if ($qrCodeSvg && !$sessionGuardada)
                <div class="mt-8 text-center">
                    <!-- Animación de entrada para el QR -->
                    <div class="animate-fade-in-up">
                        <h2 class="text-4xl font-bold bg-gradient-to-r from-green-600 via-blue-600 to-purple-600 bg-clip-text text-transparent mb-8">
                             ¡Tu código QR está listo!
                        </h2>
                        
                        <!-- Contenedor del QR con animación mejorada -->
                        <div class="inline-block relative mb-8">
                            <!-- Efectos de fondo animados -->
                            <div class="absolute -inset-8 bg-gradient-to-r from-green-400/20 via-blue-400/20 to-purple-400/20 rounded-3xl animate-pulse"></div>
                            <div class="absolute -inset-4 bg-gradient-to-r from-green-500/30 to-blue-500/30 rounded-2xl animate-ping-slow"></div>
                            
                            <!-- QR Code Container -->
                            <div class="relative glass-effect p-8 rounded-3xl hover-lift group">
                                <!-- Decorative corner elements -->
                                <div class="absolute top-4 left-4 w-6 h-6 border-l-4 border-t-4 border-green-400 rounded-tl-lg group-hover:border-blue-400 transition-colors duration-300"></div>
                                <div class="absolute top-4 right-4 w-6 h-6 border-r-4 border-t-4 border-green-400 rounded-tr-lg group-hover:border-blue-400 transition-colors duration-300"></div>
                                <div class="absolute bottom-4 left-4 w-6 h-6 border-l-4 border-b-4 border-green-400 rounded-bl-lg group-hover:border-blue-400 transition-colors duration-300"></div>
                                <div class="absolute bottom-4 right-4 w-6 h-6 border-r-4 border-b-4 border-green-400 rounded-br-lg group-hover:border-blue-400 transition-colors duration-300"></div>
                                
                                <img src="{{ $qrCodeSvg }}" alt="QR de WhatsApp" class="mx-auto block animate-fade-in group-hover:scale-105 transition-transform duration-300" style="width: 280px; height: 280px;" />
                                
                                <!-- Scanning animation overlay -->
                                <div class="absolute inset-8 pointer-events-none">
                                    <div class="w-full h-1 bg-gradient-to-r from-transparent via-green-500 to-transparent animate-bounce opacity-50"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Instrucciones con mejor diseño -->
                        <div class="max-w-lg mx-auto">
                            <div class="glass-effect rounded-2xl p-6 hover-lift">
                                <h3 class="text-xl font-semibold text-gray-800 mb-6 flex items-center justify-center">
                                    <svg class="w-6 h-6 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                                    </svg>
                                    Instrucciones de Vinculación
                                </h3>
                                
                                <div class="space-y-4">
                                    <div class="flex items-start group hover:bg-green-50/50 rounded-lg p-3 transition-colors duration-200">
                                        <div class="bg-gradient-to-r from-green-500 to-green-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold mr-4 flex-shrink-0 group-hover:scale-110 transition-transform duration-200">1</div>
                                        <div class="text-left">
                                            <p class="font-medium text-gray-800">Abre WhatsApp en tu teléfono</p>
                                            <p class="text-sm text-gray-600">Asegúrate de tener la última versión</p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-start group hover:bg-blue-50/50 rounded-lg p-3 transition-colors duration-200">
                                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold mr-4 flex-shrink-0 group-hover:scale-110 transition-transform duration-200">2</div>
                                        <div class="text-left">
                                            <p class="font-medium text-gray-800">Ve a Menú → Dispositivos vinculados</p>
                                            <p class="text-sm text-gray-600">Busca la opción en el menú principal</p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-start group hover:bg-purple-50/50 rounded-lg p-3 transition-colors duration-200">
                                        <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold mr-4 flex-shrink-0 group-hover:scale-110 transition-transform duration-200">3</div>
                                        <div class="text-left">
                                            <p class="font-medium text-gray-800">Toca "Vincular dispositivo"</p>
                                            <p class="text-sm text-gray-600">Activa la cámara para escanear</p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-start group hover:bg-green-50/50 rounded-lg p-3 transition-colors duration-200">
                                        <div class="bg-gradient-to-r from-green-500 to-green-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold mr-4 flex-shrink-0 group-hover:scale-110 transition-transform duration-200">4</div>
                                        <div class="text-left">
                                            <p class="font-medium text-gray-800">Escanea este código QR</p>
                                            <p class="text-sm text-gray-600">Apunta la cámara al código de arriba</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de acción en fila -->
                        <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center items-center">
                            <!-- Botón regenerar QR -->
                            <button 
                                wire:click="regenerarQR" 
                                class="btn-glow hover-lift bg-gradient-to-r from-blue-500 via-purple-500 to-blue-600 hover:from-blue-600 hover:via-purple-600 hover:to-blue-700 text-white font-semibold py-3 px-6 rounded-2xl shadow-xl transform transition-all duration-300 relative overflow-hidden group"
                                wire:loading.attr="disabled"
                            >
                                <span wire:loading.remove wire:target="regenerarQR" class="flex items-center space-x-2">
                                    <svg class="w-5 h-5 group-hover:animate-spin" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Nuevo QR</span>
                                </span>
                                <span wire:loading wire:target="regenerarQR" class="flex items-center space-x-2">
                                    <div class="w-5 h-5 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                                    <span>Regenerando...</span>
                                </span>
                                
                                <!-- Efecto de brillo en hover -->
                                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent transform -skew-x-12 translate-x-full group-hover:translate-x-[-100%] transition-transform duration-700"></div>
                            </button>

                            <!-- Botón guardar sesión -->
                            <button 
                                wire:click="guardarSesion" 
                                class="btn-glow hover-lift bg-gradient-to-r from-emerald-500 via-teal-500 to-emerald-600 hover:from-emerald-600 hover:via-teal-600 hover:to-emerald-700 text-white font-semibold py-3 px-6 rounded-2xl shadow-xl transform transition-all duration-300 relative overflow-hidden group"
                                wire:loading.attr="disabled"
                            >
                                <span wire:loading.remove wire:target="guardarSesion" class="flex items-center space-x-2">
                                    <svg class="w-5 h-5 group-hover:animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M7.707 10.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V6h5a2 2 0 012 2v7a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2h5v5.586l-1.293-1.293zM9 4a1 1 0 012 0v2H9V4z"></path>
                                    </svg>
                                    <span>Guardar Sesión</span>
                                </span>
                                <span wire:loading wire:target="guardarSesion" class="flex items-center space-x-2">
                                    <div class="w-5 h-5 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                                    <span>Guardando...</span>
                                </span>
                                
                                <!-- Efecto de brillo en hover -->
                                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent transform -skew-x-12 translate-x-full group-hover:translate-x-[-100%] transition-transform duration-700"></div>
                            </button>

                            <!-- Botón enviar mensaje de prueba -->
                            <button 
                                wire:click="enviarMensajePrueba" 
                                class="btn-glow hover-lift bg-gradient-to-r from-orange-500 via-red-500 to-pink-600 hover:from-orange-600 hover:via-red-600 hover:to-pink-700 text-white font-semibold py-3 px-6 rounded-2xl shadow-xl transform transition-all duration-300 relative overflow-hidden group"
                                wire:loading.attr="disabled"
                            >
                                <span wire:loading.remove wire:target="enviarMensajePrueba" class="flex items-center space-x-2">
                                    <svg class="w-5 h-5 group-hover:animate-bounce" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                    </svg>
                                    <span>Test Mensaje</span>
                                </span>
                                <span wire:loading wire:target="enviarMensajePrueba" class="flex items-center space-x-2">
                                    <div class="w-5 h-5 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                                    <span>Enviando...</span>
                                </span>
                                
                                <!-- Efecto de brillo en hover -->
                                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent transform -skew-x-12 translate-x-full group-hover:translate-x-[-100%] transition-transform duration-700"></div>
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Mostrar estado de sesión guardada -->
            @if ($sessionGuardada)
                <div class="mt-8 text-center">
                    <div class="animate-fade-in-up">
                        <!-- Icono de sesión activa -->
                        <div class="mb-8 relative">
                            <!-- Círculo de fondo elegante -->
                            <div class="absolute inset-0 w-32 h-32 bg-gradient-to-br from-green-400/20 via-emerald-500/20 to-teal-600/20 rounded-full mx-auto animate-pulse"></div>
                            <div class="absolute inset-0 w-40 h-40 bg-gradient-to-br from-green-300/10 to-emerald-400/10 rounded-full mx-auto animate-ping-slow"></div>
                            
                            <!-- Icono principal -->
                            <div class="relative z-10 animate-float">
                                <svg width="120" height="120" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="text-green-500 mx-auto drop-shadow-2xl">
                                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/>
                                    <path d="M8 12l2 2 4-4" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            
                            <!-- Partículas flotantes -->
                            <div class="absolute top-4 left-8 w-2 h-2 bg-green-400 rounded-full animate-bounce" style="animation-delay: 0.2s;"></div>
                            <div class="absolute top-8 right-6 w-3 h-3 bg-emerald-400 rounded-full animate-bounce" style="animation-delay: 0.5s;"></div>
                            <div class="absolute bottom-6 left-12 w-2 h-2 bg-teal-400 rounded-full animate-bounce" style="animation-delay: 0.8s;"></div>
                            <div class="absolute bottom-8 right-10 w-2 h-2 bg-green-500 rounded-full animate-bounce" style="animation-delay: 1s;"></div>
                        </div>

                        <!-- Título principal -->
                        <h2 class="text-5xl font-bold bg-gradient-to-r from-green-500 via-emerald-600 to-teal-600 bg-clip-text text-transparent mb-4">
                            🎉 ¡Sesión Activa!
                        </h2>
                        
                        <!-- Subtítulo -->
                        <p class="text-xl text-gray-600 mb-8">
                            Tu WhatsApp está conectado y listo para usar
                        </p>

                        <!-- Información de la sesión -->
                        <div class="max-w-md mx-auto glass-effect rounded-2xl p-6 mb-8 hover-lift">
                            <div class="flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                                <h3 class="text-lg font-semibold text-gray-800">Información de Sesión</h3>
                            </div>
                            
                            <div class="space-y-3 text-sm text-gray-600">
                                <div class="flex justify-between items-center">
                                    <span class="font-medium">Session ID:</span>
                                    <span class="bg-gray-100 px-3 py-1 rounded-full text-xs font-mono">{{ $currentSessionId }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="font-medium">Estado:</span>
                                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">Conectado</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="font-medium">Base de Datos:</span>
                                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-semibold">Guardado</span>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de acción para sesión activa -->
                        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                            <!-- Botón enviar mensaje de prueba -->
                            <button 
                                wire:click="enviarMensajePrueba" 
                                class="btn-glow hover-lift bg-gradient-to-r from-green-500 via-emerald-600 to-teal-600 hover:from-green-600 hover:via-emerald-700 hover:to-teal-700 text-white font-semibold py-4 px-8 rounded-2xl shadow-xl transform transition-all duration-300 relative overflow-hidden group"
                                wire:loading.attr="disabled"
                            >
                                <span wire:loading.remove wire:target="enviarMensajePrueba" class="flex items-center space-x-3">
                                    <svg class="w-6 h-6 group-hover:animate-bounce" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                    </svg>
                                    <span class="text-lg">Enviar Mensaje de Prueba</span>
                                </span>
                                <span wire:loading wire:target="enviarMensajePrueba" class="flex items-center space-x-2">
                                    <div class="w-5 h-5 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                                    <span>Enviando...</span>
                                </span>
                                
                                <!-- Efecto de brillo en hover -->
                                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent transform -skew-x-12 translate-x-full group-hover:translate-x-[-100%] transition-transform duration-700"></div>
                            </button>

                            <!-- Botón nueva sesión -->
                            <button 
                                wire:click="nuevaSesion" 
                                class="btn-glow hover-lift bg-gradient-to-r from-gray-500 via-gray-600 to-gray-700 hover:from-gray-600 hover:via-gray-700 hover:to-gray-800 text-white font-semibold py-4 px-8 rounded-2xl shadow-xl transform transition-all duration-300 relative overflow-hidden group"
                                wire:loading.attr="disabled"
                                wire:loading.target="nuevaSesion"
                            >
                                <span wire:loading.remove wire:target="nuevaSesion" class="flex items-center space-x-3">
                                    <svg class="w-6 h-6 group-hover:animate-spin" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-lg">Crear Nueva Sesión</span>
                                </span>
                                
                                <span wire:loading wire:target="nuevaSesion" class="flex items-center space-x-2">
                                    <div class="w-5 h-5 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                                    <span>Procesando...</span>
                                </span>
                                
                                <!-- Efecto de brillo en hover -->
                                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent transform -skew-x-12 translate-x-full group-hover:translate-x-[-100%] transition-transform duration-700"></div>
                            </button>
                        </div>

                        <!-- Características activas -->
                        <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-4 max-w-2xl mx-auto">
                            <div class="glass-effect rounded-xl p-4 hover-lift">
                                <div class="text-green-500 mb-2">
                                    <svg class="w-8 h-8 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <h4 class="font-semibold text-gray-800 text-sm">Conexión Segura</h4>
                                <p class="text-xs text-gray-600 mt-1">Encriptado de extremo a extremo</p>
                            </div>
                            
                            <div class="glass-effect rounded-xl p-4 hover-lift">
                                <div class="text-blue-500 mb-2">
                                    <svg class="w-8 h-8 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                                    </svg>
                                </div>
                                <h4 class="font-semibold text-gray-800 text-sm">API Lista</h4>
                                <p class="text-xs text-gray-600 mt-1">Envío de mensajes disponible</p>
                            </div>
                            
                            <div class="glass-effect rounded-xl p-4 hover-lift">
                                <div class="text-purple-500 mb-2">
                                    <svg class="w-8 h-8 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <h4 class="font-semibold text-gray-800 text-sm">Persistente</h4>
                                <p class="text-xs text-gray-600 mt-1">Guardado en base de datos</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- CSS personalizado para animaciones mejoradas -->
        <style>
            /* Animaciones de entrada suaves */
            @keyframes fadeIn {
                from { 
                    opacity: 0; 
                    backdrop-filter: blur(0px);
                }
                to { 
                    opacity: 1; 
                    backdrop-filter: blur(8px);
                }
            }

            @keyframes scaleIn {
                from {
                    opacity: 0;
                    transform: scale(0.9) translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: scale(1) translateY(0);
                }
            }

            @keyframes float {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-8px); }
            }

            @keyframes textShine {
                0% { background-position: -200% center; }
                100% { background-position: 200% center; }
            }

            @keyframes progressGlow {
                0%, 100% { box-shadow: 0 0 5px rgba(34, 197, 94, 0.3); }
                50% { box-shadow: 0 0 20px rgba(34, 197, 94, 0.6), 0 0 30px rgba(34, 197, 94, 0.4); }
            }

            /* Barras de progreso mejoradas */
            @keyframes progressBar {
                0% { width: 0%; }
                20% { width: 15%; }
                40% { width: 35%; }
                60% { width: 55%; }
                80% { width: 80%; }
                100% { width: 100%; }
            }

            @keyframes progressBarFast {
                0% { width: 0%; }
                30% { width: 60%; }
                100% { width: 100%; }
            }

            /* Animaciones específicas */
            .animate-fade-in {
                animation: fadeIn 0.4s ease-out forwards;
            }

            .animate-scale-in {
                animation: scaleIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
            }

            .animate-float {
                animation: float 3s ease-in-out infinite;
            }

            .animate-text-shine {
                background: linear-gradient(90deg, #374151, #10b981, #374151);
                background-size: 200% 100%;
                background-clip: text;
                -webkit-background-clip: text;
                animation: textShine 2s ease-in-out infinite;
            }

            .animate-progress-glow {
                animation: progressGlow 2s ease-in-out infinite;
            }

            .animate-spin-slow {
                animation: spin 3s linear infinite;
            }

            .animate-ping-slow {
                animation: ping 3s cubic-bezier(0, 0, 0.2, 1) infinite;
            }

            /* Entrada de pasos con retraso */
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .animate-fade-in-up {
                animation: fadeInUp 0.8s ease-out;
            }

            .step-animation {
                opacity: 0;
                animation: fadeInUp 0.6s ease-out forwards;
            }

            /* Efectos glassmorphism mejorados */
            .glass-effect {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(16px);
                border: 1px solid rgba(255, 255, 255, 0.2);
                box-shadow: 
                    0 8px 32px rgba(0, 0, 0, 0.1),
                    inset 0 1px 0 rgba(255, 255, 255, 0.4);
            }

            /* Hover effects mejorados */
            .hover-lift {
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .hover-lift:hover {
                transform: translateY(-2px);
                box-shadow: 
                    0 12px 40px rgba(0, 0, 0, 0.15),
                    0 4px 12px rgba(0, 0, 0, 0.1);
            }

            /* Efectos de brillo en botones */
            .btn-glow {
                position: relative;
                overflow: hidden;
            }

            .btn-glow::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
                transition: left 0.5s;
            }

            .btn-glow:hover::before {
                left: 100%;
            }
        </style>
    </div>
</div>