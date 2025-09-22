<?php

namespace App\Livewire\Modelos;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class ListModelPrioridad extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $search = '';
    protected $paginationTheme = 'tailwind';

    public $showModal = false;
    public $selectedModel = null;

    public $form = [
        'ing_a_cargo'  => null,
        'asistente_1'  => null,
        'asistente_2'  => null,
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function edit($modelId)
    {
        $this->selectedModel = $modelId;

        $map = DB::table('responsables_modelo')
            ->where('id_modelo', $modelId)
            ->pluck('id_user', 'prioridad');

        $this->form['ing_a_cargo'] = $map[1] ?? null;
        $this->form['asistente_1'] = $map[2] ?? null;
        $this->form['asistente_2'] = $map[3] ?? null;

        $this->showModal = true;
    }

    public function update()
    {
        if (!$this->selectedModel) return;

        foreach ([1 => 'ing_a_cargo', 2 => 'asistente_1', 3 => 'asistente_2'] as $prio => $field) {
            DB::table('responsables_modelo')
                ->where('id_modelo', $this->selectedModel)
                ->where('prioridad', $prio)
                ->delete();

            if ($this->form[$field]) {
                DB::table('responsables_modelo')->insert([
                    'id_modelo'        => $this->selectedModel,
                    'id_user'          => $this->form[$field],
                    'prioridad'        => $prio,
                    'fecha_asignacion' => now(),
                ]);
            }
        }

        $this->dispatch('saved');
        $this->showModal = false;
    }

    public function render()
    {
        // tabla pivot en columnas
        $query = DB::table('modelos')
            ->leftJoin('responsables_modelo', 'modelos.id', '=', 'responsables_modelo.id_modelo')
            ->leftJoin('users', 'responsables_modelo.id_user', '=', 'users.id')
            ->when(
                $this->search,
                fn($q) =>
                $q->where('modelos.descripcion', 'like', "%{$this->search}%")
            )
            ->select(
                'modelos.id',
                'modelos.descripcion as modelo',
                DB::raw("MAX(CASE WHEN responsables_modelo.prioridad = 1 THEN CONCAT(users.name, ' ', users.lastname) END) as ing_a_cargo"),
                DB::raw("MAX(CASE WHEN responsables_modelo.prioridad = 2 THEN CONCAT(users.name, ' ', users.lastname) END) as asistente_1"),
                DB::raw("MAX(CASE WHEN responsables_modelo.prioridad = 3 THEN CONCAT(users.name, ' ', users.lastname) END) as asistente_2"),

            )
            ->groupBy('modelos.id', 'modelos.descripcion')
            ->orderBy('modelos.id');

        $rows  = $query->paginate($this->perPage);
        $users = DB::table('users')->select('id', 'name', 'lastname')->where('area_id', 2)->orderBy('name')->get();

        return view('livewire.modelos.list-model-prioridad', [
            'rows'  => $rows,
            'users' => $users,
        ]);
    }
}
