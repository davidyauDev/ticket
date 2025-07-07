<div class="p-4" x-data="{ tab: 'agentes' }">
    <div class="flex border-b mb-4 gap-2">
        <button @click="tab = 'agentes'"
            :class="tab === 'agentes' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-500'"
            class="px-4 py-2 font-semibold focus:outline-none">Agentes Prioridad</button>
    </div>
    <div x-show="tab === 'agentes'">
        @livewire('settings.agent-assignment.index')
    </div>
</div>
