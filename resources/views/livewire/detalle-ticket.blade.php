<div class="p-6 bg-white rounded-lg shadow-md">
    <div class="flex items-center mb-6">
        <button onclick="window.location.href='{{ route('tickets.index') }}'" class="inline-flex items-center justify-center gap-2 text-sm font-medium 
            ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 
            focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none 
            disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-9 rounded-md px-3 mr-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-arrow-left mr-2 h-4 w-4">
                <path d="m12 19-7-7 7-7"></path>
                <path d="M19 12H5"></path>
            </svg>Volver
        </button>
        <h1 class="text-2xl font-bold">Ticket #{{ $ticket->codigo }}</h1>
        <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold
            bg-red-100 text-red-800 hover:bg-red-100 ml-4" data-v0-t="badge">
            {{ $ticket->estado->nombre ?? 'Sin estado' }}
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-6">
            <div class="rounded-lg border bg-card shadow-sm">
                <div class="p-6">
                    <h3 class="text-2xl font-semibold">Detalles del Ticket</h3>
                </div>
                <div class="p-6 pt-0 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-muted-foreground">Falla Reportada</p>
                            <p>{{ $ticket->falla_reportada ?? 'Sin información' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-muted-foreground">Tipo</p>
                            <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold
                                bg-blue-100 text-blue-800 hover:bg-blue-100">
                                {{ $ticket->tipo ?? 'No especificado' }}
                            </div>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-muted-foreground">Técnico</p>
                            <p>{{ $ticket->tecnico_nombres ?? 'Sin técnico asignado' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-muted-foreground">Agencia</p>
                            <p>{{ $ticket->agencia->nombre ?? 'Sin agencia' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-muted-foreground">Área</p>
                            <p>{{ $ticket->area_id ?? 'Sin Área' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-muted-foreground">Asignado a</p>
                            <p>{{ $ticket->assignedUser->name ?? 'No asignado' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-muted-foreground">Comentario</p>
                            <p class="mt-1">{{ $ticket->comentario ?? 'No hay comentarios' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-muted-foreground">Observación</p>
                            <p class="mt-1">{{ $ticket->observacion ?? 'No hay observaciones' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
            <div class="flex flex-col space-y-1.5 p-6">
                <h3 class="text-2xl font-semibold leading-none tracking-tight flex items-center"><svg
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-clock mr-2 h-5 w-5">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>Historial del Ticket</h3>
            </div>
            <div class="p-6 pt-0">
                <div class="relative">
                    <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-slate-200"></div>
                    <div class="flex mb-8 last:mb-0 relative">
                        <div class="
                    w-8 h-8 rounded-full flex items-center justify-center z-10
                    bg-blue-100 text-blue-800
                  "><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-user h-4 w-4">
                                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg></div>
                        <div class="ml-4">
                            <div class="flex items-center">
                                <h4 class="font-medium">Ticket Creado</h4>
                                <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 text-foreground ml-2 text-xs"
                                    data-v0-t="badge">10/05/2025, 9:15 AM</div>
                            </div>
                            <p class="text-sm text-muted-foreground mt-1">Ticket #45474 creado en el sistema</p>
                            <div class="flex items-center mt-2"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-user h-3 w-3 mr-1 text-muted-foreground">
                                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                <p class="text-xs text-muted-foreground">Rafael Luigi</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex mb-8 last:mb-0 relative">
                        <div class="
                    w-8 h-8 rounded-full flex items-center justify-center z-10
                    bg-indigo-100 text-indigo-800
                  "><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-user h-4 w-4">
                                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg></div>
                        <div class="ml-4">
                            <div class="flex items-center">
                                <h4 class="font-medium">Asignado a Técnico</h4>
                                <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 text-foreground ml-2 text-xs"
                                    data-v0-t="badge">10/05/2025, 9:30 AM</div>
                            </div>
                            <p class="text-sm text-muted-foreground mt-1">El ticket fue asignado a un técnico para su
                                revisión</p>
                            <div class="flex items-center mt-2"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-user h-3 w-3 mr-1 text-muted-foreground">
                                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                <p class="text-xs text-muted-foreground">Sistema</p>
                            </div>
                            <div class="mt-2 flex items-center">
                                <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 text-foreground text-xs bg-slate-50"
                                    data-v0-t="badge"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-clock h-3 w-3 mr-1">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <polyline points="12 6 12 12 16 14"></polyline>
                                    </svg>15 minutos después de creación</div>
                            </div>
                            <div class="mt-2 flex items-center"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-corner-down-right h-3 w-3 mr-1 text-muted-foreground">
                                    <polyline points="15 10 20 15 15 20"></polyline>
                                    <path d="M4 4v7a4 4 0 0 0 4 4h12"></path>
                                </svg>
                                <p class="text-xs text-muted-foreground">Derivado a: Omar Humberto Julian Grillo</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex mb-8 last:mb-0 relative">
                        <div class="
                    w-8 h-8 rounded-full flex items-center justify-center z-10
                    bg-slate-100 text-slate-800
                  "><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-message-square h-4 w-4">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                            </svg></div>
                        <div class="ml-4">
                            <div class="flex items-center">
                                <h4 class="font-medium">Comentario Añadido</h4>
                                <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 text-foreground ml-2 text-xs"
                                    data-v0-t="badge">10/05/2025, 10:45 AM</div>
                            </div>
                            <p class="text-sm text-muted-foreground mt-1">Se añadió un diagnóstico inicial al ticket</p>
                            <div class="flex items-center mt-2"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-user h-3 w-3 mr-1 text-muted-foreground">
                                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                <p class="text-xs text-muted-foreground">Omar Humberto Julian Grillo</p>
                            </div>
                            <div class="mt-2 flex items-center">
                                <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 text-foreground text-xs bg-slate-50"
                                    data-v0-t="badge"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-clock h-3 w-3 mr-1">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <polyline points="12 6 12 12 16 14"></polyline>
                                    </svg>1 hora y 15 minutos después de asignación</div>
                            </div>
                        </div>
                    </div>
                    <div class="flex mb-8 last:mb-0 relative">
                        <div class="
                    w-8 h-8 rounded-full flex items-center justify-center z-10
                    bg-purple-100 text-purple-800
                  "><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-corner-down-right h-4 w-4">
                                <polyline points="15 10 20 15 15 20"></polyline>
                                <path d="M4 4v7a4 4 0 0 0 4 4h12"></path>
                            </svg></div>
                        <div class="ml-4">
                            <div class="flex items-center">
                                <h4 class="font-medium">Derivado a Soporte Nivel 2</h4>
                                <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 text-foreground ml-2 text-xs"
                                    data-v0-t="badge">10/05/2025, 11:30 AM</div>
                            </div>
                            <p class="text-sm text-muted-foreground mt-1">El ticket fue escalado a un nivel superior de
                                soporte</p>
                            <div class="flex items-center mt-2"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-user h-3 w-3 mr-1 text-muted-foreground">
                                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                <p class="text-xs text-muted-foreground">Omar Humberto Julian Grillo</p>
                            </div>
                            <div class="mt-2 flex items-center">
                                <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 text-foreground text-xs bg-slate-50"
                                    data-v0-t="badge"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-clock h-3 w-3 mr-1">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <polyline points="12 6 12 12 16 14"></polyline>
                                    </svg>45 minutos después del diagnóstico</div>
                            </div>
                            <div class="mt-2 flex items-center"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-corner-down-right h-3 w-3 mr-1 text-muted-foreground">
                                    <polyline points="15 10 20 15 15 20"></polyline>
                                    <path d="M4 4v7a4 4 0 0 0 4 4h12"></path>
                                </svg>
                                <p class="text-xs text-muted-foreground">Derivado a: Equipo de Soporte Nivel 2</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex mb-8 last:mb-0 relative">
                        <div class="
                    w-8 h-8 rounded-full flex items-center justify-center z-10
                    bg-slate-100 text-slate-800
                  "><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-message-square h-4 w-4">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                            </svg></div>
                        <div class="ml-4">
                            <div class="flex items-center">
                                <h4 class="font-medium">Solución Propuesta</h4>
                                <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 text-foreground ml-2 text-xs"
                                    data-v0-t="badge">11/05/2025, 9:00 AM</div>
                            </div>
                            <p class="text-sm text-muted-foreground mt-1">Se identificó la necesidad de reemplazar el
                                hardware</p>
                            <div class="flex items-center mt-2"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-user h-3 w-3 mr-1 text-muted-foreground">
                                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                <p class="text-xs text-muted-foreground">María Sánchez</p>
                            </div>
                            <div class="mt-2 flex items-center">
                                <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 text-foreground text-xs bg-slate-50"
                                    data-v0-t="badge"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-clock h-3 w-3 mr-1">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <polyline points="12 6 12 12 16 14"></polyline>
                                    </svg>21 horas y 30 minutos después de derivación</div>
                            </div>
                        </div>
                    </div>
                    <div class="flex mb-8 last:mb-0 relative">
                        <div class="
                    w-8 h-8 rounded-full flex items-center justify-center z-10
                    bg-emerald-100 text-emerald-800
                  "><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-circle-check-big h-4 w-4">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <path d="m9 11 3 3L22 4"></path>
                            </svg></div>
                        <div class="ml-4">
                            <div class="flex items-center">
                                <h4 class="font-medium">Ticket Resuelto</h4>
                                <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 text-foreground ml-2 text-xs"
                                    data-v0-t="badge">12/05/2025, 10:00 AM</div>
                            </div>
                            <p class="text-sm text-muted-foreground mt-1">Se reemplazó la unidad defectuosa y se
                                verificó su funcionamiento</p>
                            <div class="flex items-center mt-2"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-user h-3 w-3 mr-1 text-muted-foreground">
                                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                <p class="text-xs text-muted-foreground">María Sánchez</p>
                            </div>
                            <div class="mt-2 flex items-center">
                                <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 text-foreground text-xs bg-slate-50"
                                    data-v0-t="badge"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-clock h-3 w-3 mr-1">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <polyline points="12 6 12 12 16 14"></polyline>
                                    </svg>25 horas después de la solución propuesta</div>
                            </div>
                        </div>
                    </div>
                    <div class="flex mb-8 last:mb-0 relative">
                        <div class="
                    w-8 h-8 rounded-full flex items-center justify-center z-10
                    bg-red-100 text-red-800
                  "><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-circle-alert h-4 w-4">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" x2="12" y1="8" y2="12"></line>
                                <line x1="12" x2="12.01" y1="16" y2="16"></line>
                            </svg></div>
                        <div class="ml-4">
                            <div class="flex items-center">
                                <h4 class="font-medium">Ticket Cerrado</h4>
                                <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 text-foreground ml-2 text-xs"
                                    data-v0-t="badge">12/05/2025, 2:30 PM</div>
                            </div>
                            <p class="text-sm text-muted-foreground mt-1">El usuario confirmó que el problema fue
                                resuelto satisfactoriamente</p>
                            <div class="flex items-center mt-2"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-user h-3 w-3 mr-1 text-muted-foreground">
                                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                <p class="text-xs text-muted-foreground">Rafael Luigi</p>
                            </div>
                            <div class="mt-2 flex items-center">
                                <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 text-foreground text-xs bg-slate-50"
                                    data-v0-t="badge"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-clock h-3 w-3 mr-1">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <polyline points="12 6 12 12 16 14"></polyline>
                                    </svg>4 horas y 30 minutos después de resolución</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>