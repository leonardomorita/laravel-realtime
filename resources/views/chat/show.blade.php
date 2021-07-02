<x-app-layout>
    <x-slot name="customStyles">
        <style></style>
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-12">
                        <div class="col-span-10">
                            <div class="grid grid-cols-2 border border-gray-400 rounded p-2 mb-2">
                                <div class="col-span-2">
                                    <ul
                                        id="messages"
                                        class="overflow-auto"
                                        style="height: 45vh"
                                    >
                                        <li>Test1: Hello</li>
                                        <li>Test2: Hello!</li>
                                    </ul>
                                </div>
                            </div>

                            <form action="" class="grid grid-cols-5">
                                <div class="col-start-1 col-end-4">
                                    <input type="text" id="message" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                </div>

                                <div class="col-start-5 col-end-6">
                                    <button
                                        id="send"
                                        type="submit"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full focus:outline-none focus:shadow-outline"
                                    >
                                        Send
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="col-span-2">
                            <p class="text-center"><strong>Online Now</strong></p>
                            <ul
                                id="users"
                                class="overflow-auto pl-1"
                                style="height: 45vh"
                            >
                                <li>Test1</li>
                                <li>Test2</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            const usersElement = document.getElementById('users');

            /* Presence Channel */
            Echo.join('chat')
                .here((users) => {
                    users.forEach((user, index) => {
                        let element = document.createElement('li');
                        element.setAttribute('id', user.id);
                        element.innerText = user.name;

                        usersElement.appendChild(element);
                    });
                })
                .joining((user) => {
                    let element = document.createElement('li');
                    element.setAttribute('id', user.id);
                    element.innerText = user.name;

                    usersElement.appendChild(element);
                })
                .leaving((user) => {
                    let userElement = document.getElementById(user.id);
                    userElement.parentNode.removeChild(userElement);
                });
        </script>
    </x-slot>
</x-app-layout>
