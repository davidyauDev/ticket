<?php

namespace App\Livewire\Users;

use App\Models\Area;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;

class EditUser extends Component
{
    public $showModal = false;
    public $userId;
    public $nombres, $apellidos, $email, $password, $direccion, $phone, $dni;
    public $areas = [];
    public $subareas = [];
    public $areaSeleccionada = null;
    public $subareaSeleccionada ;
    public bool $esSupervisor = false;

    public function mount()
    {
        $this->areas = \App\Models\Area::whereNull('parent_id')->get();
        $this->subareas = collect(); // vacío hasta que se cargue un área
    }


    #[On('editarUsuario')]
    public function cargarUsuario($id)
    {
        $user = User::findOrFail($id);

        $this->userId = $user->id;
        $this->nombres = $user->name;
        $this->apellidos = $user->lastname;
        $this->email = $user->email;
        $this->dni = $user->dni;
        $this->direccion = $user->direccion;
        $this->phone = $user->phone;
        $this->subareaSeleccionada = $user->area_id;
        $this->esSupervisor = $user->role === 'Supervisor';

        $subarea = Area::find($user->area_id);
        $areaPadre = $subarea?->parent;
        if ($areaPadre) {
            $this->areaSeleccionada = $areaPadre->id;
            Log::info($this->areaSeleccionada);
            $this->subareas = Area::where('parent_id', $areaPadre->id)->get();
            Log::info($this->subareas);
        } else {
            $this->areaSeleccionada = null;
            $this->subareas = collect();
        }

        $this->showModal = true;
    }

    public function actualizarUsuario()
    {
        $this->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->userId,
            'dni' => 'required|digits:8|unique:users,dni,' . $this->userId,
            'direccion' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:15',
        ]);

        $user = User::findOrFail($this->userId);

        $user->update([
            'name' => $this->nombres,
            'lastname' => $this->apellidos,
            'email' => $this->email,
            'dni' => $this->dni,
            'direccion' => $this->direccion,
            'phone' => $this->phone,
            'area_id' => $this->subareaSeleccionada,
            'role' => $this->esSupervisor ? 'Supervisor' : 'user',
        ]);

        $this->reset();
        $this->showModal = false;

        $this->dispatch('user-updated');
    }

    public function actualizarSubareas()
    {
        $this->subareas = Area::where('parent_id', $this->areaSeleccionada)->get();
        $this->subareaSeleccionada = null;
    }

    public function render()
    {
        return view('livewire.users.edit-user');
    }
}
