require('./bootstrap');

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { createI18n } from 'vue-i18n';
import { fr } from '../lang/fr';
import { en } from '../lang/en';

const appName =
    window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

const i18n = createI18n({
    locale: 'fr', // set locale
    fallbackLocale: 'en',
    messages: {
        fr,
        en,
    }, // set locale messages
});

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(i18n)
            .mixin({ methods: { route } })
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
