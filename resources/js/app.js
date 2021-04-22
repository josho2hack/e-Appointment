require('./bootstrap');

// Import modules...
import { createApp, h } from 'vue';
import { App as InertiaApp, plugin as InertiaPlugin } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import VueHtmlToPaper from 'vue-html-to-paper';

const el = document.getElementById('app');

createApp({
    metaInfo: {
        titleTemplate: (title) => title ? `${title} - e-Appointment` : 'e-Appointment'
      },
    render: () =>
        h(InertiaApp, {
            initialPage: JSON.parse(el.dataset.page),
            resolveComponent: (name) => require(`./Pages/${name}`).default,
        }),
})
    .mixin(require('./base'))
    .use(InertiaPlugin,VueHtmlToPaper)
    .mount(el);

InertiaProgress.init({ color: '#4B5563' });
