import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import VueTheMask from 'vue-the-mask';
const appName = import.meta.env.VITE_APP_NAME || 'Laravel';
import CKEditor from '@ckeditor/ckeditor5-vue';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const application = createApp({render: () => h(App, props)})
            .use(plugin)
            .use(VueTheMask)
            .use(CKEditor)
            .use(ZiggyVue)
            .mount(el);

        delete el.dataset.page

        return application;
    },
    progress: {
        color: '#4B5563',
    },
});
