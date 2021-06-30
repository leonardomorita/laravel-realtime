require('./bootstrap');

require('alpinejs');

Echo.channel('notifications')
    .listen('UserSessionChanged', (e) => {
        const notificationElement = document.getElementById('notification');
        const messageNotificationElement = document.getElementById('message-notification');

        messageNotificationElement.innerText = e.message;
        notificationElement.classList.remove('invisible');

        if (e.type == 'success')  {
            notificationElement.className = 'bg-green-100 border border-green-400 text-green-700';
        } else {
            notificationElement.className = 'bg-red-100 border border-red-400 text-red-700';
        }
    });
