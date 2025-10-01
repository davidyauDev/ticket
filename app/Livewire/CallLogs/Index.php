<?php

namespace App\Livewire\CallLogs;

use Livewire\Component;
use App\Models\CallLog;
use App\Models\Option;
use App\Models\Tecnico;
use App\Models\User;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log as FacadesLog;


class Index extends Component
{
    use WithPagination;
    public int $perPage = 8;
    public $search = '';
    public $typeFilter = '';
    public $showModal = false;
    public $editingId = null;
    public $suboptions = [];
    public $searchTecnico = '';
    public $tecnicoList = [];
    public $form = [
        'type' => 'Consulta',
        'option_id' => '',
        'user_id' => '',
        'tecnico_id' => '',
        'description' => ''
    ];

    protected $rules = [
        'form.type' => 'required',
        'form.option_id' => 'required|exists:options,id',
        'form.user_id' => 'nullable|exists:users,id',
        'form.description' => 'required|string|min:5',
        'form.tecnico_id' => 'nullable|exists:tecnicos,id',
    ];

    public function updatedSearchTecnico()
    {
        $this->tecnicoList = Tecnico::where(function ($query) {
        $query->where('firstname', 'like', '%' . $this->searchTecnico . '%')
              ->orWhere('lastname', 'like', '%' . $this->searchTecnico . '%');
    })
    ->limit(10)
    ->get()
    ->toArray();
    }

    public function selectTecnico($id)
    {
        $tecnico = Tecnico::find($id);

        if ($tecnico) {
            $this->form['tecnico_id'] = $tecnico->id;
            $this->searchTecnico = $tecnico->lastname . ' ' . $tecnico->firstname;
            $this->tecnicoList = [];
        }
    }



    public function render()
    {
        $callLogs = CallLog::with('tecnico')
            ->when($this->search, function ($q) {
                $search = $this->search;
                $q->whereHas('tecnico', function ($query) use ($search) {
                    $query->where('firstname', 'like', '%' . $search . '%')
                        ->orWhere('lastname', 'like', '%' . $search . '%');
                });
            })
            ->latest()
            ->paginate($this->perPage);

        $seguimientoPadre = Option::where('group', 'seguimiento_tecnico')
            ->where('label', 'SEGUIMIENTO AL TECNICO')
            ->first();

        $this->suboptions = $seguimientoPadre
            ? $seguimientoPadre->children()->get()
            : [];

        return view('livewire.call-logs.index', [
            'callLogs' => $callLogs,
            'tecnicos' => Tecnico::all(),
            'seguimientoOpciones' => $this->suboptions,
        ]);
    }


    public function resetForm()
    {
        $this->form = [
            'type' => 'Consulta',
            'option_id' => '',
            'user_id' => '',
            'tecnico_id' => null,
            'description' => ''
        ];

        $this->editingId = null;
        $this->searchTecnico = '';
        $this->tecnicoList = [];
        $this->dispatch('reset-tecnico');
    }


    public function create()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function store()
    {
        FacadesLog::info('Storing call log', $this->form);
        $this->validate();
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
        $this->form = $call->only('type', 'user_id', 'description', 'tecnico_id', 'option_id');
        if ($call->tecnico) {
            $this->searchTecnico = $call->tecnico->lastname . ' ' . $call->tecnico->firstname;
        } else {
            $this->searchTecnico = '';
        }
        $this->editingId = $id;
        $this->showModal = true;
    }

    public function delete($id)
    {
        CallLog::destroy($id);
        session()->flash('message', 'Llamada eliminada.');
    }
}
