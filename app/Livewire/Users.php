<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;

    protected $listeners = ['user-saved' => '$refresh'];

    public $stats;
    public $search = '';
    protected $queryString = ['search'];
    public $showModal = false;

    public $nombres;
    public $apellidos;
    public $email;
    public $password;
    public $direccion;
    public $celular;
    public $dni;


    public function mount()
    {
        $this->stats = $this->getStatsData();
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

    $this->reset(['nombres', 'apellidos', 'email', 'password', 'direccion', 'celular', 'dni', 'showModal']);

    $this->dispatch('user-saved');
}


    // public function crearUsuario()
    // {
    //     $this->dispatch('user-created', nombre: 'David');
    // }

    public function openModal()
{
    $this->reset(['nombres', 'apellidos', 'email', 'password', 'direccion', 'celular', 'dni']);
    $this->showModal = true;
}


    public function editarUsuario($id)
    {
        $this->dispatch('user-edited', $id);
    }

    public function miMetodo($valor)
    {
        Log::info($valor);
    }

    public function getStatsData()
    {
        return [
            [
                'title' => 'Cantidad de Usuarios',
                'value' => '550',
                'trend' => '16.2%',
                'trendUp' => true
            ],
            [
                'title' => 'Usuarios Online',
                'value' => '428',
                'trend' => '12.4%',
                'trendUp' => false
            ],

        ];
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);

        return view('livewire.users', [
            'users' => $users,
        ]);
    }
}
