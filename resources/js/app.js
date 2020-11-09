require('./bootstrap');

import Vue from 'vue';

import { InertiaApp } from '@inertiajs/inertia-vue';
import { InertiaProgress } from '@inertiajs/progress';
import { InertiaForm } from 'laravel-jetstream';
import PortalVue from 'portal-vue';
import VCalendar from 'v-calendar';

var VueScrollTo = require('vue-scrollto');


Vue.mixin({ methods: { route } });
Vue.use(InertiaApp);
Vue.use(InertiaForm);
Vue.use(PortalVue);
Vue.use(VueScrollTo);
Vue.use(VCalendar);

InertiaProgress.init();

const app = document.getElementById('app');

new Vue({
    render: (h) =>
        h(InertiaApp, {
            props: {
                initialPage: JSON.parse(app.dataset.page),
                resolveComponent: (name) => require(`./Pages/${name}`).default,
                // resolveComponent: name => import(`./Pages/${name}`).then(module => module.default),

            },
        }),
}).$mount(app);
