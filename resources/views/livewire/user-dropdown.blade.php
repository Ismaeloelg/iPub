<div class="relative">
    @if($user)
        <button wire:click="toggleDropdown"
                aria-expanded="{{ $dropdownOpen ? 'true' : 'false' }}"
                class="flex items-center space-x-2 focus:outline-none">
            <span class="font-semibold text-white">{{ $user->name }}</span>
            <img src="{{ $user->avatar ?? asset('images/default_avatar.png') }}"
                 alt="Avatar" class="w-10 h-10 rounded-full border-2 border-white">
        </button>

        <div class="absolute right-0 mt-2 w-50 bg-gray-800 rounded-xl shadow-lg py-2 transition-all duration-300
                {{ $dropdownOpen ? 'block opacity-100' : 'hidden opacity-0' }}">
            <a href="{{ route('profile') }}" class="block px-4 py-2 text-white hover:bg-blue-700">Perfil</a>

            @if($user->hasRole($roleAdmin))
                <a href="{{ route('manager-profile') }}" class="block px-4 py-2 text-white hover:bg-blue-700">Administrar Perfil</a>
                <a href="{{ route('showStock') }}" class="block px-4 py-2 text-white hover:bg-green-700">Administrar Productos</a>
                <a href="{{ route('stock') }}" class="block px-4 py-2 text-white hover:bg-green-700">Añadir Productos</a>
                <a href="{{ route('categoria') }}" class="block px-4 py-2 text-white hover:bg-green-700">Añadir Categoria</a>
                <a href="#" class="block px-4 py-2 text-white hover:bg-yellow-600">Crear Usuario</a>
            @endif

            <a href="{{ route('logout') }}" class="block px-4 py-2 text-white hover:bg-red-600">Cerrar sesión</a>
        </div>
    </div>
@endif
