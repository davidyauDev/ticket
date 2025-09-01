<div class="space-y-6 p-5">
    {{-- <div class="p-4 mt-4 border rounded-xl bg-white ">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex bg-gray-100 p-1 rounded-lg">
                <button wire:click="switchTab('mis')" @class([
                    'px-4 py-1.5 text-sm font-medium rounded-md',
                    'bg-black text-white' => $tab === 'mis',
                    'text-gray-700 hover:bg-gray-200' => $tab !== 'mis',
                ])>
                    Mis Tickets
                </button>
                <button wire:click="switchTab('todos')" @class([
                    'px-4 py-1.5 text-sm font-medium rounded-md',
                    'bg-black text-white' => $tab === 'todos',
                    'text-gray-700 hover:bg-gray-200' => $tab !== 'todos',
                ])>
                    Todos del Área
                </button>
            </div>
            <div class="flex justify-between items-center">
                @if (auth()->user()?->area?->parent_id == 1)
                    <button wire:click="$dispatch('abrirModalCreacionTicket')"
                        class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600">
                        Nuevo ticket por llamada <svg class="fill-current" width="20" height="20"
                            viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M9.2502 4.99951C9.2502 4.5853 9.58599 4.24951 10.0002 4.24951C10.4144 4.24951 10.7502 4.5853 10.7502 4.99951V9.24971H15.0006C15.4148 9.24971 15.7506 9.5855 15.7506 9.99971C15.7506 10.4139 15.4148 10.7497 15.0006 10.7497H10.7502V15.0001C10.7502 15.4143 10.4144 15.7501 10.0002 15.7501C9.58599 15.7501 9.2502 15.4143 9.2502 15.0001V10.7497H5C4.58579 10.7497 4.25 10.4139 4.25 9.99971C4.25 9.5855 4.58579 9.24971 5 9.24971H9.2502V4.99951Z"
                                fill=""></path>
                        </svg></button>
                @else
                    <div
                        class="rounded-xl border p-4 border-warning-500 bg-warning-50 dark:border-warning-500/30 dark:bg-warning-500/15">
                        <div class="flex items-start gap-3">
                            <div class="-mt-0.5 text-warning-500"><svg width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fillRule="evenodd" clipRule="evenodd"
                                        d="M3.6501 12.0001C3.6501 7.38852 7.38852 3.6501 12.0001 3.6501C16.6117 3.6501 20.3501 7.38852 20.3501 12.0001C20.3501 16.6117 16.6117 20.3501 12.0001 20.3501C7.38852 20.3501 3.6501 16.6117 3.6501 12.0001ZM12.0001 1.8501C6.39441 1.8501 1.8501 6.39441 1.8501 12.0001C1.8501 17.6058 6.39441 22.1501 12.0001 22.1501C17.6058 22.1501 22.1501 17.6058 22.1501 12.0001C22.1501 6.39441 17.6058 1.8501 12.0001 1.8501ZM10.9992 7.52517C10.9992 8.07746 11.4469 8.52517 11.9992 8.52517H12.0002C12.5525 8.52517 13.0002 8.07746 13.0002 7.52517C13.0002 6.97289 12.5525 6.52517 12.0002 6.52517H11.9992C11.4469 6.52517 10.9992 6.97289 10.9992 7.52517ZM12.0002 17.3715C11.586 17.3715 11.2502 17.0357 11.2502 16.6215V10.945C11.2502 10.5308 11.586 10.195 12.0002 10.195C12.4144 10.195 12.7502 10.5308 12.7502 10.945V16.6215C12.7502 17.0357 12.4144 17.3715 12.0002 17.3715Z"
                                        fill="currentColor"></path>
                                </svg></div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Solo las áreas bajo <strong>Mesa de
                                        Ayuda</strong> pueden crear tickets.</p><!---->
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div> --}}
    <!-- Tabla y Modal -->
    <livewire:ticket.ticket-list :tipo="$tab" wire:key="tickets-table-{{ $tab }}" />
    <livewire:ticket.ticket-form-modal wire:key="ticket-form-modal" />
</div>
@script
    <script>
        $wire.on("user-saved", () => {
            Swal.fire({
                icon: 'success',
                title: 'Ticket',
                text: 'Ticket registrado exitosamente'
            });
        })
        $wire.on("notify1", () => {
            Swal.fire({
                icon: 'success',
                title: 'Ticket',
                text: 'Ticket asignado exitosamente'
            });
        })
       
        $wire.on("notifyError", () => {
            Swal.fire({
                icon: 'error',
                title: 'Ticket',
                text: 'Error al registrar el ticket'
            });
        })
        $wire.on("anular", () => {
            Swal.fire({
                icon: 'success',
                title: 'Ticket',
                text: 'Anulado exitosamente'
            });
        })
    </script>
@endscript
