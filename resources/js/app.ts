import './bootstrap';
import '@fontsource-variable/outfit';
import 'remixicon/fonts/remixicon.css';
import '../css/app.css';

import { createApp, h, DefineComponent } from 'vue';
import {createInertiaApp} from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import mitt from 'mitt';

const appName = import.meta.env.VITE_APP_NAME || 'Lumetra';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob<DefineComponent>('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .provide('emitter', mitt())
            .mount(el);
    },
    progress: {
        color: '#2657D2',
    },
});
