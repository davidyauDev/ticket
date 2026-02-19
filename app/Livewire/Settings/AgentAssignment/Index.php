<?php
namespace App\Livewire\Settings\AgentAssignment;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public array $users = [];

    public function mount()
    {
        $user = Auth::user();
        if (!$user) {
            $this->users = [];
            return;
        }

        $this->users = [
            [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'available' => (bool) $user->available,
            ],
        ];
    }

    public function updateAvailability($userId, $available)
    {
        $user = Auth::user();
        if (!$user || (int) $user->id !== (int) $userId) {
            return;
        }

        $normalized = filter_var($available, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        $user->available = $normalized === null ? (bool) $available : $normalized;
        $user->save();

        if (!empty($this->users)) {
            $this->users[0]['available'] = (bool) $user->available;
        }

        $this->dispatch('availability-updated');
    }

    public function render()
    {
        return view('livewire.settings.agent-assignment.index', [
            'users' => $this->users
        ]);
    }
}
