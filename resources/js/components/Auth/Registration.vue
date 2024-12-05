<template>
    <v-card
        class="mx-auto"
        style="max-width: 500px;"
    >
        <v-toolbar
            color="deep-purple-accent-4"
            cards
            dark
            flat
        >
            <v-card-title class="text-h6 font-weight-regular">
                Регистрация
            </v-card-title>
        </v-toolbar>
        <v-form
            ref="form"
            v-model="isValid"
            class="pa-4 pt-6"
        >
            <v-text-field
                v-model="name"
                :rules="[rules.required]"
                color="deep-purple"
                label="Имя"
                variant="filled"
            ></v-text-field>
            <v-text-field
                v-model="email"
                :rules="[rules.email, rules.required]"
                color="deep-purple"
                label="Почтовый адрес"
                type="email"
                variant="filled"
            ></v-text-field>
            <v-text-field
                v-model="password"
                :rules="[rules.password, rules.required, rules.length(6)]"
                color="deep-purple"
                counter="6"
                label="Пароль"
                style="min-height: 96px"
                type="password"
                variant="filled"
            ></v-text-field>
        </v-form>
        <v-divider></v-divider>
        <v-card-actions>

            <v-btn
                @click.prevent="login"
                :disabled="!isValid"
                :loading="isLoading"
                color="deep-purple-accent-4"
            >
                Submit
            </v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
    import axios from 'axios';
    import {toast} from "vue3-toastify";
    export default {
        name: "Registration",
        data() {
            return {
                email: null,
                name: null,
                password: null,
                isValid: false,
                isLoading: false,
                rules: {
                    email: v => !!(v || '').match(/@/) || 'Введите корректный адрес электронной почты',
                    length: len => v => (v || '').length >= len || `Минимальная длина ${len}`,
                    required: v => !!v || 'Это поле обязательно',
                },
            }
        },
        methods: {
            async login() {
                try {
                    const response = await axios.post('/api/register', {
                        name: this.name,
                        email: this.email,
                        password: this.password
                    });
                    if (response.status === 200) {
                        this.$router.push('/')
                        toast.success('Регистрация прошла успешно');
                    } else {
                        toast.error('Неизвестная ошибка при регистрации');
                    }
                } catch (error) {
                    let errorMessage = 'Произошла ошибка при регистрации';

                    if (error.response) {
                        errorMessage = error.response.data.message || errorMessage;
                    } else if (error.request) {
                        errorMessage = 'Нет ответа от сервера';
                    } else {
                        errorMessage = error.message;
                    }

                    toast.error(errorMessage);
                }
            }
        }
    }
</script>

<style scoped>

</style>
