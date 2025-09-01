<?php

namespace App\Livewire\Users;

use App\Models\User;
use App\Models\Area;
use Livewire\Attributes\On;
use Livewire\Component;

class CreateUser extends Component
{
    public $showModal = false;
    public $nombres, $apellidos, $email, $password, $direccion, $celular, $dni;
    public $areas = [];
    public $subareas = [];
    public $areaSeleccionada;
    public $subareaSeleccionada;
    public bool $esSupervisor = false;

    #[On('abrirModalCreacionUsuario')]
    public function abrirModal()
    {
        $this->showModal = true;
    }

    public function crearUsuario()
    {
        $this->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'direccion' => 'nullable|string|max:255',
            'celular' => 'nullable|string|max:20',
            'dni' => 'nullable|string|max:20',
        ]);

        User::create([
            'name' => $this->nombres,
            'lastname' => $this->apellidos,
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'direccion' => $this->direccion,
            'phone' => $this->celular,
            'dni' => $this->dni,
            'area_id' => $this->subareaSeleccionada,
            'role' => $this->esSupervisor ? 'Supervisor' : 'user',
        ]);

        $this->reset();
        $this->dispatch('user-saved');
    }

    public function mount()
    {
        $this->areas = Area::whereNull('parent_id')->get();
        $this->subareas = Area::whereNotNull('parent_id')->get();
    }

    public function actualizarSubareas()
    {
        $this->subareas = Area::where('parent_id', $this->areaSeleccionada)->get();
    }

    public function render()
    {
        return view('livewire.users.create-user');
    }
}
