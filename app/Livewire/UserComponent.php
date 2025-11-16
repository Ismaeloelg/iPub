<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class UserComponent extends Component
{
    // Variables
    public $users;
    public $inputPassword;
    public $selectedUser = null;
    public $showUserModal = false;

    // Cargar datos al montar el componente
    public function mount()
    {
        $this->users = User::get();
    }

    // Renderizar la vista
    public function render()
    {
        return view('livewire.user-component');
    }

    // Seleccionar usuario
    public function selectUser($id)
    {
        $this->selectedUser = User::find($id);
        $this->showUserModal = true;
    }

    // Comprobar password
    public function checkPassword()
    {
        if ($this->selectedUser) {
            if (Hash::check($this->inputPassword, $this->selectedUser->password)) {
                session()->flash('success', 'Password correcto');
                session(['logged_user' => $this->selectedUser]);
                return redirect()->route('home');
            } else {
                $this->inputPassword = null;
                session()->flash('error', 'Password incorrecto');
            }
        }
    }

    // Cerrar modal
    public function closeModal()
    {
        $this->showUserModal = false;
        $this->selectedUser = null;
        $this->inputPassword = null;
    }
}
