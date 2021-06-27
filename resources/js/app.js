require('./bootstrap');

require('alpinejs');

Echo.channel('notifications')
    .listen('UserSessionChanged', (e) => {
        const notificationElement = document.getElementById('notification');
        const messageNotificationElement = document.getElementById('message-notification');

        messageNotificationElement.innerText = e.message;
        notificationElement.classList.remove('invisible');
        notificationElement.classList.remove('bg-red-100 border border-red-400 text-red-700');
        notificationElement.classList.remove('bg-green-100 border border-green-400 text-green-700');

        if (e.type == 'success')  {
            notificationElement.classList.add('bg-green-100 border border-green-400 text-green-700');
        } else {
            notificationElement.classList.add('bg-red-100 border border-red-400 text-red-700');
        }
    });
