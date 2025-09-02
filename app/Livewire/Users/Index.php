<?php

namespace App\Livewire\Users;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $search = '';
    protected $listeners = ['user-updated' => '$refresh'];

    public function openCreateModal()
    {
        $this->dispatch('abrirModalCreacionUsuario');
    }

    public function editarUsuario($id)
    {
        $this->dispatch('editarUsuario', id: $id);
    }

    public function render()
    {

        $users = User::query()
            ->whereNotNull('area_id')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->paginate(8);

        return view('livewire.users.index', [
            'users' => $users,
        ]);
    }
}
