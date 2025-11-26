<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\WithFileUploads;

class ProfileComponent extends Component
{
    use WithFileUploads;

    public $user;
    public $name;
    public $avatar;
    public $avatarPreview;
    public $role;
    public $password;

    public function mount()
    {
        $userId = session('logged_user_id');
        $this->user = $userId ? User::find($userId) : null;

        if ($this->user) {
            $this->name = $this->user->name;
            $this->role = $this->user->role;
            $this->avatarPreview = $this->user->avatar ? asset('storage/'.$this->user->avatar) : null;
        }
    }

    public function updatedAvatar()
    {
        $this->validate([
            'avatar' => 'image|max:1024',
        ]);

        $this->avatarPreview = $this->avatar->temporaryUrl();
    }

    public function updateProfile()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|in:user,admin',
            'password' => 'nullable|string|min:6',
            'avatar' => 'nullable|image|max:1024', // 1MB máximo
        ]);

        if ($this->user) {
            $this->user->name = $this->name;
            $this->user->role = $this->role;

            if ($this->password) {
                $this->user->password = Hash::make($this->password);
            }

            // Guardar avatar en public/images
            if ($this->avatar) {
                $filename = time() . '_' . $this->avatar->getClientOriginalName();
                $this->avatar->move(public_path('images'), $filename);
                $this->user->avatar = 'images/' . $filename; // ruta relativa al public
            }

            $this->user->save();

            session()->flash('message', 'Perfil actualizado correctamente.');
        }
    }


    public function render()
    {
        return view('livewire.profile-component');
    }
}
