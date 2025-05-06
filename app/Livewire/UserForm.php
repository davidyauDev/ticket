<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Attributes\Validate;

class UserForm extends Component
{
    #[Validate('required|string|min:3')]
    public string $name = '';

    #[Validate('required|email|unique:users,email')]
    public string $email = '';
    public string $password = '';
    public string $direccion = '';
    public string $phone = '';
    public string $dni = '';

    #[Validate('required|string|min:6')]

    public ?User $editing = null;
    public bool $showModal = false;
    public string $message = ''; // Propiedad para mensajes de estado

    public $listeners = [
        'edit-user' => 'edit',
        'create-user' => 'create',
    ];

    #[On('edit-user')]
    public function edit($userId)
    {
        //Log::info($userId);
        // // Obtener el usuario por su ID
        // $this->editing = User::find($userId);

        // if ($this->editing) {
        //     Log::info('Editing user: ' . $this->editing->name);
        //     // Cargar los datos del usuario en los campos
        //     $this->name = $this->editing->name;
        //     $this->email = $this->editing->email;
        //     //$this->showModal = true;
        // }
    }

    #[On('user-created')]
    public function handleUserCreated($nombre)
    {
        $this->reset(['name', 'email', 'password', 'editing']);
    }

    #[On('user-edited')]
    public function handleUserEdited($id)
    {
        $this->editing = User::find($id);
        if ($this->editing) {
            $this->name = $this->editing->name;
            $this->email = $this->editing->email;
        }
    }

    public function create()
    {
        Log::info('Creating new user');
        $this->reset(['name', 'email', 'password', 'editing']);
    }

    public function save()
    {
        try {
            $this->validate();
            if ($this->editing) {
                $this->editing->update([
                    'name' => $this->name,
                    'email' => $this->email,
                    'password' => bcrypt($this->password),
                ]);
            } else {
                User::create([
                    'name' => $this->name,
                    'email' => $this->email,
                    'password' => bcrypt($this->password),
                ]);
            }
            $this->dispatch('user-saved');
            $this->message = 'Usuario guardado exitosamente.';
            $this->showModal = false;
        } catch (\Exception $e) {
            Log::error('Error al guardar el usuario: ' . $e->getMessage());
            $this->message = 'Ocurrió un error al guardar el usuario.';
        }
    }

    public function render()
    {
        return view('livewire.user-form');
    }
}
