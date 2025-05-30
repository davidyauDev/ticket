<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class CreateUser extends Component
{

    public $showModal = false;
    public $nombres, $apellidos, $email, $password, $direccion, $celular, $dni;

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
        ]);

        $this->reset();
        $this->dispatch('user-saved');
    }

    public function render()
    {
        return view('livewire.users.create-user');
    }
}
