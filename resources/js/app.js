require('./bootstrap');

// Import modules...
import Vue from 'vue';
import { App as InertiaApp, plugin as InertiaPlugin } from '@inertiajs/inertia-vue';
import PortalVue from 'portal-vue';
import vuetify from "../plugins/vuetify";
import store from "@/Store";
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";

import VueSignaturePad from 'vue-signature-pad';

Vue.use(VueSignaturePad);

const app = document.getElementById('app');
const options = { containerClassName: "ct-notification" };

Vue.mixin({
    methods: {
        $role(roleName) {
            return this.$page.props.role.indexOf(roleName) !== -1;
        },
        $can(permissionName) {
            return this.$page.props.permission.indexOf(permissionName) !== -1;
        }
    }
})
Vue.use(Toast, options);
Vue.mixin({ methods: { route } });
Vue.use(InertiaPlugin);
Vue.use(PortalVue);
Vue.prototype.$toastOption = {
    position: "top-right",
    timeout: 3000,
    hideProgressBar: true,
    closeButton: "button",
    icon: true,
}

Vue.mixin({
    methods: {
        route: route
    }
});

new Vue({
    render: (h) =>
        h(InertiaApp, {
            props: {
                initialPage: JSON.parse(app.dataset.page),
                resolveComponent: (name) => require(`./Pages/${name}`).default,
            },
        }),
    vuetify,
    store,
}).$mount(app);


