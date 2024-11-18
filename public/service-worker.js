// Installing service worker
const CACHE_NAME = "Sidipusba3-pwa";

/* Add relative URL of all the static content you want to store in
 * cache storage (this will help us use our app offline)*/
let resourcesToCache = [
  "assets/js/vue.min.js",
  "assets/js/bootstrap.bundle.min.js",
  "assets/js/vuetify.min.js",
  "assets/js/axios.min.js",
  "assets/js/main.js",
  "assets/js/vue-plyr.min.js",
  "assets/js/vue-carousel.min.js",
  "assets/css/materialdesignicons.min.css",
  "assets/css/vuetify.min.css",
  "assets/css/bootstrap.min.css",
  "assets/css/vue-plyr.css",
  "assets/css/styles.css",
];

self.addEventListener("install", (e) => {
  e.waitUntil(
    caches
      .open(CACHE_NAME)
      .then((cache) => {
        return cache.addAll(resourcesToCache);
      })
      .then(self.skipWaiting())
  );
});

// Cache and return requests
self.addEventListener("fetch", function (event) {
  event.respondWith(
    fetch(event.request).catch(() => {
      return caches.open(CACHE_NAME).then((cache) => {
        return cache.match(event.request);
      });
    })
  );
});

// Update a service worker
const cacheWhitelist = [CACHE_NAME];
self.addEventListener("activate", (event) => {
  event.waitUntil(
    caches
      .keys()
      .then((cacheNames) => {
        return Promise.all(
          cacheNames.map((cacheName) => {
            if (cacheWhitelist.indexOf(cacheName) === -1) {
              return caches.delete(cacheName);
            }
          })
        );
      })
      .then(() => self.clients.claim())
  );
});
