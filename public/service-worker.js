const CACHE_NAME = 'soul-ia-cache';
const urlsToCache = [
    '/',
    '/manifest.json',
    '/css/app.css',
    '/js/app.js'
    // Adicione outras rotas, CSS e JS que devem ser cacheadas.
];

self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => {
                console.log('Cache aberto');
                return cache.addAll(urlsToCache);
            })
    );
});

self.addEventListener('fetch', event => {
    event.respondWith(
        caches.match(event.request)
            .then(response => {
                return response || fetch(event.request);
            })
    );
});