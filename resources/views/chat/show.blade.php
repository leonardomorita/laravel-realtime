<x-app-layout>
    <x-slot name="customStyles">
        <style>
            #users > li {
                cursor: pointer;
            }
        </style>
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
                                    </ul>
                                </div>
                            </div>

                            <form action="" class="grid grid-cols-5">
                                <div class="col-start-1 col-end-4">
                                    <input
                                        type="text"
                                        id="message"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    >
                                </div>

                                <div class="col-start-5 col-end-6">
                                    <button
                                        type="submit"
                                        id="send"
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
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            function sortList(users) {
                var i, switching, user, shouldSwitch;

                switching = true;

                /* Make a loop that will continue until
                no switching has been done: */
                while (switching) {
                    switching = false;
                    user = users.getElementsByTagName("li");

                    // Loop through all list items:
                    for (i = 0; i < (user.length - 1); i++) {
                        shouldSwitch = false;
                        /* Check if the next item should
                        switch place with the current item: */
                        if (user[i].innerHTML.toLowerCase() > user[i + 1].innerHTML.toLowerCase()) {
                            /* If next item is alphabetically lower than current item,
                            mark as a switch and break the loop: */
                            shouldSwitch = true;
                            break;
                        }
                    }

                    if (shouldSwitch) {
                        /* If a switch has been marked, make the switch
                        and mark the switch as done: */
                        console.log(user[i].parentNode);
                        user[i].parentNode.insertBefore(user[i + 1], user[i]);
                        switching = true;
                    }
                }
            }
        </script>

        <script>
            const usersElement = document.getElementById('users');
            const messagesElement = document.getElementById('messages');

            /* Presence Channel */
            Echo.join('chat')
                .here((users) => {
                    users.forEach((user, index) => {
                        let element = document.createElement('li');
                        element.setAttribute('id', user.id);
                        element.setAttribute('onclick', 'greetUser("' + user.id + '")');
                        element.innerText = user.name;

                        usersElement.appendChild(element);
                        sortList(usersElement);
                    });
                })
                .joining((user) => {
                    let element = document.createElement('li');
                    element.setAttribute('id', user.id);
                    element.setAttribute('onclick', 'greetUser("' + user.id + '")');
                    element.innerText = user.name;

                    usersElement.appendChild(element);
                    sortList(usersElement);
                })
                .leaving((user) => {
                    let userElement = document.getElementById(user.id);
                    userElement.parentNode.removeChild(userElement);
                })
                .listen('MessageSent', (e) => {
                    let element = document.createElement('li');
                    element.innerText = `${e.user.name}: ${e.message}`;

                    messagesElement.appendChild(element);
                });
        </script>

        <script>
            const messageElement = document.getElementById('message');
            const sendElement = document.getElementById('send');

            sendElement.addEventListener('click', (e) => {
                e.preventDefault();

                window.axios.post('/chat/message', {
                    message: messageElement.value
                });

                messageElement.value = '';
            });
        </script>

        <script>
            function greetUser(id) {
                window.axios.post(`/chat/greet/${id}`);
            }
        </script>
    </x-slot>
</x-app-layout>
