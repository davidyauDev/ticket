<?php

namespace App\Livewire\CallLogs;

use Livewire\Component;
use App\Models\CallLog;
use App\Models\User;
use Illuminate\Container\Attributes\Log;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth; // Importar la clase Auth
use Illuminate\Support\Facades\Log as FacadesLog;



class Index extends Component
{
    use WithPagination;


    public $search = '';
    public $typeFilter = '';
    public $showModal = false;
    public $editingId = null;

    public $form = [
        'type' => 'Consulta',
        'user_id' => '',
        'tecnico_id' => '',
        'description' => ''
    ];

    protected $rules = [
        'form.type' => 'required|in:Consulta,Reclamo,Soporte',
        'form.user_id' => 'nullable|exists:users,id', // Cambiado a nullable
        'form.description' => 'required|string|min:5',
        'form.tecnico_id' => 'nullable|exists:users,id', // Asegúrate de que este campo esté en la migración
    ];

    public function render()
    {
        $callLogs = CallLog::with('user')
            ->when($this->search, fn($q) => $q->where('description', 'like', '%' . $this->search . '%'))
            ->when($this->typeFilter, fn($q) => $q->where('type', $this->typeFilter))
            ->latest()
            ->paginate(10);

        return view('livewire.call-logs.index', [
            'callLogs' => $callLogs,
            'tecnicos' => User::whereNull('area_id')
                ->where('role', '!=', 'admin')
                ->get()
        ]);
    }

    public function resetForm()
    {
        $this->form = [
            'type' => 'Consulta',
            'user_id' => '',
            'tecnico_id' => '',
            'description' => ''
        ];

        $this->editingId = null;
        $this->dispatch('reset-tecnico'); // 👈 esto está bien
    }


    public function create()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function store()
    {
        $this->validate();
        FacadesLog::info('Storing call log', $this->form);
        if (empty($this->form['user_id'])) {
            $this->form['user_id'] = Auth::id();
        }

        if ($this->editingId) {
            CallLog::findOrFail($this->editingId)->update($this->form);
        } else {
            CallLog::create($this->form);
        }

        $this->resetForm();
        $this->showModal = false;
        $this->dispatch('saved');
    }

    public function edit($id)
    {
        $call = CallLog::findOrFail($id);
        $this->form = $call->only('type', 'user_id', 'description', 'tecnico_id');
        $this->editingId = $id;
        $this->showModal = true;
    }

    public function delete($id)
    {
        CallLog::destroy($id);
        session()->flash('message', 'Llamada eliminada.');
    }
}
