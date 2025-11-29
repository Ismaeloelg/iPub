<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class UserDropdown extends Component
{
    public $user;
    public $dropdownOpen = false;
    public $roleAdmin;

    public function mount()
    {
        $userId = session('logged_user_id');
        $this->user = $userId ? User::find($userId) : null;
        $this->roleAdmin = User::ROLE_ADMIN; // Pasamos la constante a Blade
    }

    public function toggleDropdown()
    {
        $this->dropdownOpen = !$this->dropdownOpen;
    }

    public function render()
    {
        return view('livewire.user-dropdown');
    }
}
