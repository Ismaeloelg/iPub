<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class   ManagerProfilesComponent extends Component
{
    public $users;
    public $selectedUser = null;
    public $showUserModal = false;

    public $name;
    public $role;
    public $password;

    public function mount()
    {
        $this->users = User::all();
    }

    public function selectUser($id)
    {
        $this->selectedUser = User::findOrFail($id);

        // Rellenar inputs
        $this->name = $this->selectedUser->name;
        $this->role = $this->selectedUser->role;

        $this->showUserModal = true;
    }

    public function updateProfile()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|in:user,admin',
            'password' => 'nullable|string|min:6',
        ]);

        if ($this->selectedUser) {
            $this->selectedUser->name = $this->name;
            $this->selectedUser->role = $this->role;

            if ($this->password) {
                $this->selectedUser->password = Hash::make($this->password);
            }

            $this->selectedUser->save();

            session()->flash('message', 'Perfil actualizado correctamente.');
        }
    }
    public function deleteUser()
    {
        if ($this->selectedUser) {
            // Eliminar usuario
            $this->selectedUser->delete();

            // Limpiar los campos y cerrar el modal
            $this->reset(['selectedUser', 'name', 'role', 'password']);
            $this->showUserModal = false;

            // Mensaje de éxito
            session()->flash('message', 'Usuario eliminado correctamente.');

            // Recargar la lista de usuarios
            $this->users = User::all();
        }
    }


    public function render()
    {
        return view('livewire.manager-profiles-component');
    }
}
