import { createApp } from 'vue';
import { createRouter,  createWebHistory } from "vue-router";
import { routes } from "./routes";
import 'vue3-toastify/dist/index.css';
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

import App from './components/App.vue'
let app = createApp(App)

const vuetify = createVuetify({
    components,
    directives,
})


const router = createRouter({
    history: createWebHistory(),
    routes: routes,
})



app.use(router);
app.use(vuetify)
app.mount("#app")
