<div class="bg-gray-800 py-12 min-h-screen flex flex-col items-center">

    <!-- Título -->
    <div class="text-5xl text-white mb-12 text-center">
        Administración de Usuarios
    </div>

    <!-- Lista de usuarios -->
    <div class="flex flex-wrap gap-10 justify-center">

        {{-- LISTA DE USUARIOS --}}
        @foreach($users->reverse() as $user)
            <div wire:click="selectUser({{ $user->id }})"
                 class="bg-gray-700 rounded-4xl transition duration-300 transform hover:scale-105 hover:border-blue-500 hover:shadow-2xl hover:bg-gray-600 w-56 h-72 text-white shadow-lg border-2 border-gray-600 m-4 cursor-pointer">

                <!-- Avatar del usuario -->
                <div class="bg-blue-500 border-4 border-gray-900 rounded-full w-40 h-40 mx-auto items-center justify-center text-white flex flex-col mt-6 shadow-xl">
                    <img src="{{ $user->avatar ? asset('storage/'.$user->avatar) : asset('images/defautl_avatar.png') }}" alt="Avatar"
                         class="rounded-full object-cover w-full h-full">
                </div>


                <!-- Nombre de usuario -->
                <div class="flex flex-col items-center mt-4 font-semibold">
                    <p class="text-lg">{{ $user->name }}</p>
                </div>

            </div>
        @endforeach
    </div>

    <!-- Crear Usuario Button -->
    <div class="flex flex-col items-center mb-6">
        <a href="{{route('createUser')}}"
                class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-full font-semibold shadow-lg transition-all duration-200 mb-4">
            Crear Usuario
        </a>
    </div>

    {{-- MODAL USUARIO SELECCIONADO --}}
    <flux:modal name="user-selection" wire:model="showUserModal"
                overlay-class="bg-black bg-opacity-70 backdrop-blur-lg w-full">

        @if($selectedUser)
            <form wire:submit.prevent="updateProfile"
                  class="w-full bg-white rounded-3xl shadow-2xl p-12 space-y-8 font-sans text-black">

                <h1 class="text-4xl font-extrabold text-center text-gray-800 mb-4">
                    Editar Perfil
                </h1>

                @if(session()->has('message'))
                    <div class="bg-green-100 text-green-700 p-3 rounded-md text-center animate-fade-in">
                        {{ session('message') }}
                    </div>
                @endif


                {{-- AVATAR SOLO VISTA --}}
                <div class="flex flex-col items-center">
                    <label class="block text-gray-700 font-semibold mb-2 text-lg">Avatar</label>

                    <div class="w-32 h-32 rounded-full overflow-hidden border-2 border-gray-300 mb-2">
                        <img src="{{ asset($selectedUser->avatar) }}"
                             alt="Avatar"
                             class="w-full h-full object-cover">
                    </div>

                    <p class="text-gray-500 text-sm">No editable</p>
                </div>


                {{-- NOMBRE --}}
                <div class="space-y-1">
                    <label class="block text-gray-700 font-semibold">Nombre</label>
                    <input type="text" wire:model="name"
                           class="w-full rounded-md border-gray-300 shadow p-3 focus:ring-2 focus:ring-blue-400">
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>


                {{-- ROL --}}
                <div class="space-y-1">
                    <label class="block text-gray-700 font-semibold">Rol</label>

                    <select wire:model="role"
                            class="w-full rounded-md border-gray-300 shadow p-3 focus:ring-2 focus:ring-blue-400">
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>

                    @error('role') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>


                {{-- PASSWORD --}}
                <div class="space-y-1">
                    <label class="block text-gray-700 font-semibold">Contraseña (opcional)</label>
                    <input type="password" wire:model="password"
                           class="w-full rounded-md border-gray-300 shadow p-3 focus:ring-2 focus:ring-blue-400"
                           placeholder="Nueva contraseña">
                    @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>


                {{-- BOTONES --}}
                <div class="flex flex-row gap-4">
                    <button type="submit"
                            class="w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700
                               text-white py-3 px-6 rounded-xl font-semibold shadow-lg transition-all duration-200">
                        Actualizar Perfil
                    </button>

                    <button wire:click="deleteUser({{ $selectedUser->id }})"
                            class="w-full bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700
                               text-white py-3 px-6 rounded-xl font-semibold shadow-lg transition-all duration-200">
                        Eliminar Usuario
                    </button>
                </div>
            </form>
        @endif

    </flux:modal>

</div>
