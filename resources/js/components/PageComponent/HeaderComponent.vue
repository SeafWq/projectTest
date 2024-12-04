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
            <v-tab :value="'/login'" to="/login">Авторизация</v-tab>
            <v-tab :value="'/register'" to="/register">Регистрация</v-tab>
        </v-tabs>
    </v-card>
</template>

<script>
    export default {
        data: () => ({
            tab: null,
        }),
        computed: {
            currentTab() {
                return this.$route.path;
            }
        },
        methods: {
            onTabChange(newTab) {
                this.$router.push(newTab);
            }
        }
    }
</script>
