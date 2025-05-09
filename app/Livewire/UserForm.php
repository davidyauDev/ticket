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
    public string $firstname = '';
    public string $lastname = '';

    #[Validate('nullable|string|min:6')]
    public ?User $editing = null;
    public bool $showModal = false;
    public string $message = '';

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
        $this->message = 'Crear Usuario';
        $this->reset(['name', 'email', 'password', 'editing', 'lastname', 'direccion', 'phone', 'dni']);
    }

    #[On('user-edited')]
    public function handleUserEdited($id)
    {
        $this->message = 'Editar Usuario';

        $this->editing = User::find($id);
        if ($this->editing) {
            $this->name = $this->editing->name;
            $this->email = $this->editing->email;
            $this->direccion = $this->editing->direccion ?? '';
            $this->phone = $this->editing->phone ?? '';
            $this->dni = $this->editing->dni ?? '';
            $this->firstname = $this->editing->firstname ?? '';
            $this->lastname = $this->editing->lastname ?? '';
        }
    }

    public function create()
    {
        $this->reset(['name', 'email', 'password', 'editing']);
    }

    public function save()
    {
        try {
            $rules = [
                'name' => 'required|string|min:3',
                'email' => 'required|email|unique:users,email' . ($this->editing ? ',' . $this->editing->id : ''),
                'password' => $this->editing ? 'nullable|string|min:6' : 'required|string|min:6',
            ];

            $this->validate($rules);

            if ($this->editing) {
                $this->editing->update([
                    'name' => $this->name,
                    'email' => $this->email,
                    'password' => $this->password ? bcrypt($this->password) : $this->editing->password,
                    'direccion' => $this->direccion,
                    'phone' => $this->phone,
                    'dni' => $this->dni,
                    'firstname' => $this->firstname,
                    'lastname' => $this->lastname,
                ]);
            } else {
                User::create([
                    'name' => $this->name,
                    'email' => $this->email,
                    'password' => bcrypt($this->password),
                    'direccion' => $this->direccion,
                    'phone' => $this->phone,
                    'dni' => $this->dni,
                    'firstname' => $this->firstname,
                    'lastname' => $this->lastname,

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
