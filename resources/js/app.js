import './bootstrap';
import '../css/app.css';

import {createApp, h} from 'vue';
import {createInertiaApp} from '@inertiajs/vue3';
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers';
import {ZiggyVue} from '../../vendor/tightenco/ziggy/dist/vue.m';
import Login from "@/Pages/Auth/Login.vue";
import {createRouter, createWebHashHistory} from "vue-router";
import {routes} from "@/routes";


// const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';
// createInertiaApp({
//     title: (title) => `${title} - ${appName}`,
//     resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
//     setup({el, App, props, plugin}) {
//         return createApp({render: () => h(App, props)})
//             .use(plugin)
//             .use(ZiggyVue, Ziggy)
//             .mount(el);
//     },
//     progress: {
//         color: '#4B5563',
//     },
// });

const router = createRouter({
    history: createWebHashHistory(),
    routes,
})
const app = createApp({})
    .use(ZiggyVue, Ziggy);
app.use(router)
app.mount('#app')
