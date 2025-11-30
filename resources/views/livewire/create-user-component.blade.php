<div class="container mx-auto p-8">
    <h1 class="text-4xl font-extrabold text-center mb-8">Crear Usuario</h1>

    @if (session()->has('message'))
        <div class="bg-green-100 text-green-700 p-3 rounded-md text-center mb-4">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="guardarUsuario" class="max-w-lg mx-auto bg-white p-8 rounded-xl shadow-md">
        <!-- Nombre -->
        <div class="mb-4">
            <label for="name" class="block text-gray-700">Nombre Completo</label>
            <input type="text" wire:model="name" id="name" class="w-full mt-1 rounded-md border-gray-300 shadow-sm" placeholder="Nombre Completo">
            @error('name')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        <!-- Avatar -->
        <div class="mb-4">
            <label for="avatar" class="block text-gray-700">Avatar</label>
            <div class="flex items-center">
                <img src="{{ $avatar ? $avatar->temporaryUrl() : asset('images/default_avatar.png') }}" alt="Avatar" class="w-20 h-20 rounded-full object-cover">
                <input type="file" wire:model="avatar" id="avatar" class="w-full mt-1 rounded-md border-gray-300 shadow-sm ml-4">
            </div>
            @error('avatar')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>


        <!-- Rol -->
        <div class="mb-4">
            <label for="role" class="block text-gray-700">Rol</label>
            <select wire:model="role" id="role" class="w-full mt-1 rounded-md border-gray-300 shadow-sm">
                <option value="user">Usuario</option>
                <option value="admin">Administrador</option>
            </select>
            @error('role')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        <!-- Contraseña -->
        <div class="mb-4">
            <label for="password" class="block text-gray-700">Contraseña</label>
            <input type="password" wire:model="password" id="password" class="w-full mt-1 rounded-md border-gray-300 shadow-sm" placeholder="Contraseña">
            @error('password')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        <!-- Confirmar Contraseña -->
        <div class="mb-4">
            <label for="password_confirmation" class="block text-gray-700">Confirmar Contraseña</label>
            <input type="password" wire:model="password_confirmation" id="password_confirmation" class="w-full mt-1 rounded-md border-gray-300 shadow-sm" placeholder="Confirmar Contraseña">
            @error('password_confirmation')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        <!-- Botón de Enviar -->
        <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition-colors">
            Crear Usuario
        </button>
    </form>
</div>
