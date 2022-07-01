require("./bootstrap");
window.Vue = require("vue");

import * as VueGoogleMaps from "vue2-google-maps";
import GmapCluster from "vue2-google-maps/dist/components/cluster";
import VueSocketIO from "vue-socket.io";
import SocketIO from 'socket.io-client'
import store from "./store"
import VModal from 'vue-js-modal/dist/index.nocss.js'
import 'vue-js-modal/dist/styles.css'
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';

Vue.component("example-component", require("./components/ExampleComponent.vue").default);
Vue.component("notifications-component", require("./components/NotificationsComponent.vue").default);
Vue.component("maps-component", require("./components/MapsComponent.vue").default);
Vue.component("map-view-component", require("./components/MapView.vue").default);

Vue.use(VModal, { componentName: "add-gps", dynamicDefault: { draggable: true, resizable: true }});
Vue.use(VueGoogleMaps, {
    load: {
        key: "AIzaSyC40Clev1ycrQdtwqme8y6U_WC472aSmJI",
        labraries:"places"
    }
});

/* Vue.use(new VueSocketIO({
    debug: false,
    connection: SocketIO("https://192.241.155.75:5005", {
        autoConnect: true
    }),
    vuex: {
        store,
        actionPrefix: 'SOCKET_',
        mutationPrefix: 'SOCKET_'
    }
})) */

Vue.component("GmapCluster", GmapCluster)
Vue.use(ElementUI);
const app = new Vue({
    store,
    el: "#wrapper",
});
