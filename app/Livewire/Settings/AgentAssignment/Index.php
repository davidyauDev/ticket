<?php

namespace App\Livewire\Settings\AgentAssignment;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public string $tab = 'agentes';
    public array $availableTabs = ['agentes', 'asignaciones', 'historial'];

    // Separar los arrays por pestaña
    public array $usersByTab = [
        'agentes' => [],
        'asignaciones' => [],
        'historial' => [],
    ];

    protected function rules()
    {
        return [
            'usersByTab.agentes.*.available' => 'boolean',
            'usersByTab.agentes.*.priority' => 'nullable|integer|min:1',

            'usersByTab.asignaciones.*.available' => 'boolean',
            'usersByTab.asignaciones.*.priority' => 'nullable|integer|min:1',

            'usersByTab.historial.*.available' => 'boolean',
            'usersByTab.historial.*.priority' => 'nullable|integer|min:1',
        ];
    }

    public function mount()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $areaTabs = [
            6 => 'agentes',
            7 => 'asignaciones',
            8 => 'historial',
        ];
        if ($user && !in_array($user->role, ['supervisor', 'admin'])) {
            // Solo puede ver el tab de su área
            $this->availableTabs = isset($areaTabs[$user->area_id]) ? [$areaTabs[$user->area_id]] : [];
            $this->tab = $this->availableTabs[0] ?? 'agentes';
        }
        $this->loadUsers();
    }

    public function switchTab($tab)
    {
        $this->tab = $tab;
        if (empty($this->usersByTab[$tab])) {
            $this->loadUsers();
        }
    }

    public function loadUsers()
    {
        $areaIds = [
            'agentes' => 6,
            'asignaciones' => 7,
            'historial' => 8,
        ];

        $user = Auth::user();
        if ($user && in_array($user->role, ['supervisor', 'admin'])) {
            // Supervisor o admin: muestra todos los usuarios del área
            $users = User::where('area_id', $areaIds[$this->tab] ?? 6)->get();
        } else {
            // No supervisor ni admin: solo su propio usuario
            $users = User::where('id', $user->id)->get();
        }

        $this->usersByTab[$this->tab] = $users
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'available' => $user->available,
                    'priority' => $user->priority,
                ];
            })
            ->toArray();
    }

    public function saveUsers()
{
    $this->validate();

    // Obtener las prioridades seleccionadas sin valores nulos
    $priorities = array_filter(array_column($this->usersByTab[$this->tab], 'priority'));

    // Contar cuántas veces se repite cada prioridad
    $duplicates = array_filter(array_count_values($priorities), function ($count) {
        return $count > 1;
    });

    // Si hay duplicados, lanzar error
    if (!empty($duplicates)) {
        session()->flash('error', 'No puedes asignar la misma prioridad a más de un agente.');
        return;
    }

    // Guardar usuarios si la validación pasa
    foreach ($this->usersByTab[$this->tab] as $userData) {
        $user = User::find($userData['id']);
        if ($user) {
            $user->available = $userData['available'];
            $user->priority = $userData['priority'];
            $user->save();
        }
    }

    session()->flash('success', 'Cambios guardados correctamente.');
}

    public function render()
    {
        return view('livewire.settings.agent-assignment.index', [
            'users' => $this->usersByTab[$this->tab] ?? []
        ]);
    }
}
