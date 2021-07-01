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
            Echo.channel('users')
                .listen('UserCreated', (e) => {
                    const usersElement = document.getElementById('users');
                    let element = document.createElement('li');
                    element.setAttribute('id', e.user.id);
                    element.innerText = e.user.name;

                    usersElement.appendChild(element);
                    sortList(usersElement);
                })
                .listen('UserUpdated', (e) => {
                    const element = document.getElementById(e.user.id);
                    element.innerText = e.user.name;
                })
                .listen('UserDeleted', (e) => {
                    const element = document.getElementById(e.user.id);
                    element.parentNode.removeChild(element);
                });
        </script>
    </x-slot>
</x-app-layout>
