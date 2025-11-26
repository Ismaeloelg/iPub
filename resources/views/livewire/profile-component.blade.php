<div>
    @if($user)
        <form wire:submit.prevent="updateProfile"
              class="rounded-2xl shadow-2xl w-1/2 m-auto p-12 space-y-6 font-medium bg-white">
            <h1 class="text-4xl font-extrabold text-center">Editar Perfil</h1>

            @if(session()->has('message'))
                <div class="bg-green-100 text-green-700 p-3 rounded-md text-center">
                    {{ session('message') }}
                </div>
            @endif

            <div class="flex flex-col items-center">
                <label class="block text-black font-medium mb-2">{{$user->rol}}</label>
                <div class="w-32 h-32 rounded-full overflow-hidden border-2 border-gray-300 mb-2">
                    @if($user->avatar)
                        <img src="{{ $user->avatar }}" alt="Avatar" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gray-100 text-gray-400">
                            Sin imagen
                        </div>
                    @endif
                </div>
                <input type="file" wire:model="avatar" class="mt-2">
                @error('avatar') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block">Nombre</label>
                <input type="text" wire:model="name"
                       class="w-full mt-1 rounded-md border-gray-300 shadow-sm"
                       placeholder="Nombre del usuario">
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>


            <div>
                <label class="block">Contraseña (opcional)</label>
                <input type="password" wire:model="password"
                       class="w-full mt-1 rounded-md border-gray-300 shadow-sm"
                       placeholder="Nueva contraseña">
                @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <button type="submit"
                    class="w-full bg-blue-600 text-white py-3 px-4 rounded-md hover:bg-blue-700 transition-colors font-semibold">
                Actualizar Perfil
            </button>
        </form>
    @else
        <p class="text-center text-gray-500 mt-10">No hay usuario autenticado.</p>
    @endif
</div>

