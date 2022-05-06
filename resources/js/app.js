require('./bootstrap');

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .mixin({ methods: { route } })
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });

//  PWA
if ('serviceWorker' in navigator) {
    navigator
        .serviceWorker
        .register('/serviceworker.js').then(registration => {
        console.log('serviceworker registered!', registration)
    }).catch(err => {
        console.log('serviceworker not registered!', err)
    })
} else {
    console.log('Service Worker is not supported.')
}

