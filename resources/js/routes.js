import App from '../js/components/App.vue'
import Articles from "./components/Pages/Articles.vue";
import Main from "./components/Pages/Main.vue";
import Login from "./components/Auth/Login.vue";
import Registration from "./components/Auth/Registration.vue";

export const routes = [
    {
        path: '/',
        component: Main,
    },
    {
        path: '/articles',
        component: Articles
    },
    {
        path: '/login',
        component: Login
    },
    {
        path: '/register',
        component: Registration
    }
];


