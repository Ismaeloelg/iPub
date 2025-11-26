<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>iPub2</title>
    @vite('resources/css/app.css')
    @fluxAppearance
    @livewireStyles
</head>
@php
    use App\Models\User;
    $userId = session('logged_user_id');
    $user = $userId ? User::find($userId) : null;
@endphp
<body class="bg-gray-800 ">
<header class="text-2xl font-bold text-white bg-gray-900 shadow-lg rounded-full m-3 ">
    <nav class="container mx-auto flex items-center justify-between p-5">
        <a href="{{ route('welcome') }}" class="text-4xl font-extrabold text-blue-400 hover:text-blue-500 transition">iPub2</a>

        @if($user)
            <div class="relative">
                <!-- Botón del avatar + nombre -->
                <button id="userButton" class="flex items-center space-x-2 focus:outline-none">
                    <span class="font-semibold text-white">{{ $user->name }}</span>
                    <img src="{{ $user->avatar ?? asset('images/default_avatar.png') }}" alt="Avatar"
                         class="w-10 h-10 rounded-full border-2 border-white">
                </button>

                <!-- Dropdown oculto por defecto -->
                <div id="userDropdown"
                     class="absolute right-5 mt-2 w-50 bg-gray-800 rounded-xl shadow-lg py-2 opacity-0 invisible transition-all z-50">
                    <a href="{{route('profile')}}" class="block px-4 py-2 text-white hover:bg-blue-700 hover:h-1/4">Perfil</a>
                    @if($user->hasRole(User::ROLE_ADMIN))
                        <a href="{{route('manager-profile')}}"
                           class="block px-4 py-2 text-white hover:bg-blue-700 hover:h-1/4">Administrar Perfil</a>
                        <a href="{{ route('showStock') }}" class="block px-4 py-2 text-white hover:bg-green-700">Administrar
                            Productos</a>
                        <a href="{{ route('stock') }}" class="block px-4 py-2 text-white hover:bg-green-700">Añadir
                            Productos</a>
                        <a href="{{ route('categoria') }}" class="block px-4 py-2 text-white hover:bg-green-700">Añadir
                            Categoria</a>
                        <a href="#" class="block px-4 py-2 text-white hover:bg-yellow-600">Crear Usuario</a>
                    @endif
                    <a href="{{ route('logout') }}" class="block px-4 py-2 text-white hover:bg-red-600">Cerrar
                        sesión</a>
                </div>

            </div>
        @endif
    </nav>
</header>


<main class="m-3">
    <div class="bg-gray-900 shadow-xl rounded-4xl auto-rows-fr h-241 overflow-y-auto min-h-0">
        {{$slot}}
    </div>
</main>

@fluxScripts
@livewireScripts
<script>
    const userButton = document.getElementById('userButton');
    const userDropdown = document.getElementById('userDropdown');

    if (userButton) {
        userButton.addEventListener('click', () => {
            const isOpen = userDropdown.classList.contains('opacity-100');
            if (isOpen) {
                userDropdown.classList.remove('opacity-100', 'visible');
                userDropdown.classList.add('opacity-0', 'invisible');
            } else {
                userDropdown.classList.remove('opacity-0', 'invisible');
                userDropdown.classList.add('opacity-100', 'visible');
            }
        });

        window.addEventListener('click', function (e) {
            if (!userButton.contains(e.target) && !userDropdown.contains(e.target)) {
                userDropdown.classList.remove('opacity-100', 'visible');
                userDropdown.classList.add('opacity-0', 'invisible');
            }
        });
    }
</script>

</body>
</html>
