<template>
    <v-card>
        <v-tabs
            v-model="currentTab"
            align-tabs="center"
            color="deep-purple-accent-4"
            @change="onTabChange"
        >
            <v-tab :value="'/'" to="/">Главная страница</v-tab>
            <v-tab :value="'/articles'" to="/articles">Каталог статей</v-tab>
            <v-tab v-if="isAuthenticated" :value="'/createNewArticle'"  to="/createNewArticle">Новая статья</v-tab>
            <v-tab v-if="!isAuthenticated" :value="'/login'" to="/login">Авторизация</v-tab>
            <v-tab v-if="!isAuthenticated" :value="'/register'" to="/register">Регистрация</v-tab>
            <v-tab v-if="isAuthenticated" :value="'/logout'"  @click="logout">Выйти</v-tab>
        </v-tabs>
    </v-card>
</template>

<script>
    import axios from '/resources/js/config/axios';
    import { toast } from "vue3-toastify";

    export default {
        data: () => ({
            isAuthenticated: false,
        }),
        computed: {
            currentTab() {
                return this.$route.path;
            }
        },
        mounted() {
            this.checkAuthentication();
        },
        watch: {
            $route(to, from) {
                this.checkAuthentication();
            }
        },
        methods: {
            checkAuthentication() {
                const token = localStorage.getItem('token');
                this.isAuthenticated = !!token;
            },
            onTabChange(newTab) {
                this.$router.push(newTab);
            },
            async logout() {
                try {
                    await axios.post('/api/logout');
                    localStorage.removeItem('token');
                    this.checkAuthentication();
                    toast.success('Вы успешно вышли из аккаунта');
                } catch (error) {
                    console.error('Ошибка при выходе:', error);
                }
            },
        }
    }
</script>
