<?php

namespace App\Livewire\CallLogs;

use Livewire\Component;
use App\Models\CallLog;
use App\Models\User;
use Livewire\WithPagination;

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
        'description' => ''
    ];

    protected $rules = [
        'form.type' => 'required|in:Consulta,Reclamo,Soporte',
        'form.user_id' => 'required|exists:users,id',
        'form.description' => 'required|string|min:5'
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
            'users' => User::all()
        ]);
    }

    public function resetForm()
    {
        $this->form = ['type' => 'Consulta', 'user_id' => '', 'description' => ''];
        $this->editingId = null;
    }

    public function create()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function store()
    {
        $this->validate();

        if ($this->editingId) {
            CallLog::findOrFail($this->editingId)->update($this->form);
        } else {
            CallLog::create($this->form);
        }

        $this->resetForm();
        $this->showModal = false;
        session()->flash('message', 'Llamada registrada exitosamente.');
    }

    public function edit($id)
    {
        $call = CallLog::findOrFail($id);
        $this->form = $call->only('type', 'user_id', 'description');
        $this->editingId = $id;
        $this->showModal = true;
    }

    public function delete($id)
    {
        CallLog::destroy($id);
        session()->flash('message', 'Llamada eliminada.');
    }
}
