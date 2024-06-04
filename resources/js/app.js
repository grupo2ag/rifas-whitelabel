import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import VueTheMask from 'vue-the-mask';
const appName = import.meta.env.VITE_APP_NAME || 'Laravel';
import CKEditor from '@ckeditor/ckeditor5-vue';
import VueSweetalert2 from 'vue-sweetalert2';
import Vue3ColorPicker from "vue3-colorpicker";
import "vue3-colorpicker/style.css";

// If you don't need the styles, do not connect
import 'sweetalert2/dist/sweetalert2.min.css';

createInertiaApp({
    title: (title) => `${title}`,
    resolve: (name) =>
        resolvePageComponent(`./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue')),
    setup({el, App, props, plugin}) {
        const app = createApp({render: () => h(App, props)})
            .use(plugin)
            .use(VueTheMask)
            .use(CKEditor)
            .use(ZiggyVue)
            .use(VueSweetalert2)
            .use(Vue3ColorPicker)
           // .mount(el);
        app.mount(el);
        delete el.dataset.page

        app.config.globalProperties.$assets = import.meta.env.VITE_ASSETS;

    },
    progress: {
        color: '#4B5563',
    },
});
