/*
* Service Worker para Web Push Notifications
*/

self.addEventListener('push', function (event) {
    console.log('[Service Worker] Push Received.');
    console.log(`[Service Worker] Push had this data: "${event.data.text()}"`);

    let data = {};
    try {
        data = event.data.json();
    } catch (e) {
        data = {
            title: 'Notificación Lanus',
            body: event.data.text(),
            icon: '/assets/img/favicon.png'
        };
    }

    const title = data.title || 'Nueva Alerta';
    const options = {
        body: data.body || 'Tenes un nuevo mensaje en el sistema.',
        icon: data.icon || '/assets/dist/img/user2-160x160.jpg',
        badge: '/assets/img/badge.png',
        data: data.url || '/'
    };

    event.waitUntil(self.registration.showNotification(title, options));
});

self.addEventListener('notificationclick', function (event) {
    console.log('[Service Worker] Notification click Received.');

    event.notification.close();

    event.waitUntil(
        clients.openWindow(event.notification.data)
    );
});
