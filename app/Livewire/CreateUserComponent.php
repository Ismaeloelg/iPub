<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Livewire\WithFileUploads;

// Necesario si vas a manejar archivos (avatar)

class CreateUserComponent extends Component
{
    use WithFileUploads;

    // Permite la carga de archivos

    public $name;
    public $avatar;
    public $role = 'user'; // Valor predeterminado
    public $password;
    public $password_confirmation;

    // Definir las reglas de validación
    protected $rules = [
        'name' => 'required|string|max:255',
        'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:1024', // 1MB máximo
        'role' => 'required|in:user,admin',
        'password' => 'required|string|min:8|confirmed', // Confirmación de contraseña
    ];

    public function guardarUsuario()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:1024', // 1MB máximo
            'role' => 'required|in:user,admin',
            'password' => 'required|string|min:8|confirmed', // Confirmación de contraseña
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no debe tener más de 255 caracteres.',
            'role.required' => 'El rol es obligatorio.',
            'role.in' => 'El rol debe ser "user" o "admin".',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        if ($this->avatar) {
            $avatarPath = $this->avatar->store('avatars', 'public');
        } else {
            $avatarPath = null;
        }

        User::create([
            'name' => $this->name,
            'avatar' => $avatarPath,
            'role' => $this->role,
            'password' => bcrypt($this->password),
        ]);

        session()->flash('message', 'Usuario creado exitosamente.');
        $this->reset();
    }


    public function render()
    {
        return view('livewire.create-user-component');
    }
}
