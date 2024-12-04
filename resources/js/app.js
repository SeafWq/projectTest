import { createApp } from 'vue';
import { createRouter,  createWebHistory } from "vue-router";
import { routes } from "./routes";
import 'vue3-toastify/dist/index.css';


import App from './components/App.vue'
import vuetify from "./vuetify";
let app = createApp(App)

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
})



app.use(router);
app.use(vuetify)
app.mount("#app")
