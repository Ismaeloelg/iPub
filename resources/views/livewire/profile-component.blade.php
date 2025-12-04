<div class=" bg-gray-900 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-xl w-full space-y-8">

        <h1 class="text-3xl font-extrabold text-center text-white">Editar Perfil</h1>
        <form wire:submit.prevent="updateProfile"
              class="bg-gray-800 rounded-2xl shadow-xl p-10 space-y-6 text-gray-100">

            @if(session()->has('message'))
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-init="setTimeout(() => show = false, 1000)"
                    class="bg-green-700 text-green-100 p-3 rounded-md text-center transition-opacity duration-500"
                >
                    {{ session('message') }}
                </div>
            @endif


            <div class="flex flex-col items-center">
                <label class="font-medium mb-2 text-gray-200">{{$user->rol}}</label>
                <div class="w-32 h-32 rounded-full overflow-hidden border-2 border-gray-600 mb-2">
                    @if($user->avatar)
                        <img src="{{ $user->avatar }}" alt="Avatar" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gray-700 text-gray-400">
                            Sin imagen
                        </div>
                    @endif
                </div>
                <input type="file" wire:model="avatar" class="mt-2 text-gray-200">
                @error('avatar') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block mb-1">Nombre</label>
                <input type="text" wire:model="name"
                       class="w-full mt-1 rounded-lg border-gray-600 bg-gray-700 text-gray-200 shadow-sm p-2"
                       placeholder="Nombre del usuario">
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block mb-1">Cambiar Contraseña</label>
                <input type="password" wire:model="password"
                       class="w-full mt-1 rounded-lg border-gray-600 bg-gray-700 text-gray-200 shadow-sm p-2"
                       placeholder="Nueva contraseña">
                @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block mb-1">Confirmar Contraseña</label>
                <input type="password" wire:model="password_confirmation"
                       class="w-full mt-1 rounded-lg border-gray-600 bg-gray-700 text-gray-200 shadow-sm p-2"
                       placeholder="Confirmar Contraseña">
                @error('password_confirmation')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
            </div>

            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 transition-colors py-3 rounded-lg font-semibold text-white">
                Actualizar Perfil
            </button>
        </form>

    </div>
</div>
