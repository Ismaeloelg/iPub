<div class="bg-gray-800 shadow-2xl rounded-4xl pt-10 p-6 md:p-8 ">


<div class="flex flex-wrap gap-10  justify-center ">

        {{--USUARIO NO SELECCIONADO--}}
        @foreach($users->reverse() as $user)
            <div wire:click="selectUser({{$user->id}})"
                 class="bg-gray-400 rounded-4xl w-48 h-68 text-black shadow-2xl border-1 m-2">
                <div
                    class="bg-blue-50 border-2 border-black rounded-full w-40 h-40 mx-auto items-center justify-center text-white flex flex-col mt-3">
                    <img src="{{ $user->avatar ?? asset('images/default_avatar.png') }}" alt="Avatar"
                         class="rounded-full">
                </div>
                <div class="flex flex-col items-center mt-5 font-bold">
                    <p>{{$user->name}}</p>

                </div>
            </div>

        @endforeach
        {{--USUARIO SELECCIONADO--}}
        <flux:modal name="user-selection" wire:model="showUserModal"
                    overlay-class="bg-black bg-opacity-70 backdrop-blur-lg ">
            @if($selectedUser)
                <div class="bg-blue-200 shadow-lg rounded-full w-86 m-6 ">
                    <p>
                        <img src="{{ $selectedUser->avatar ?? asset('images/default_avatar.png') }}" alt="Avatar"
                             class="rounded-full shadow-black border-3 shadow-2xl">
                    </p>
                </div>
                <div class="flex flex-col items-center mt-5 font-bold ">
                    <p class="text-2xl">{{$selectedUser->name}}</p>
                    <form wire:submit.prevent="checkPassword" class="text-center ">
                        <input type="password" wire:model="inputPassword" autofocus placeholder="Introduzca password"
                               class="font-light w-3/4 m-3 border-2 rounded-4xl p-4">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-4xl">Verificar</button>

                    </form>

                    <p class="{{ session('success') ? ' text-green-800 ' : (session('error') ? 'text-red-400 ' : '') }} px-4 py-3 rounded my-2">
                        {{ session('success') ?? session('error') }}
                    </p>

                </div>
            @endif
        </flux:modal>
    </div>

</div>
