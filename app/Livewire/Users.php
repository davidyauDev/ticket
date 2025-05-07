<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;

    protected $listeners = ['userUpdated' => '$refresh'];

    public $stats;
    public $search = '';
    protected $queryString = ['search'];

    public function mount()
    {
        $this->stats = $this->getStatsData();
    }

    public function crearUsuario()
    {
        $this->dispatch('user-created', nombre: 'David');
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
                'title' => 'Total revenue',
                'value' => '$38,393.12',
                'trend' => '16.2%',
                'trendUp' => true
            ],
            [
                'title' => 'Total transactions',
                'value' => '428',
                'trend' => '12.4%',
                'trendUp' => false
            ],
            [
                'title' => 'Total customers',
                'value' => '376',
                'trend' => '12.6%',
                'trendUp' => true
            ],
            [
                'title' => 'Average order value',
                'value' => '$87.12',
                'trend' => '13.7%',
                'trendUp' => true
            ]
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
