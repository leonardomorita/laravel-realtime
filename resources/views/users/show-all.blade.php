<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <ul id="users">

                    </ul>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            window.axios.get('/api/users')
                .then((response) => {
                    const usersElement = document.getElementById('users');

                    let users = response.data;
                    users.forEach((user) => {
                        let element = document.createElement('li');
                        element.setAttribute('id', user.id);
                        element.innerText = user.name;

                        usersElement.appendChild(element);
                    });
                });
        </script>
    </x-slot>
</x-app-layout>
