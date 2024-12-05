<template>
    <v-container>
        <v-card class="ma-2" style="width: 1200px;"  v-if="article">
            <v-img
                height="340px"
                src="https://cdn.vuetifyjs.com/images/cards/sunshine.jpg"
                cover
            ></v-img>
            <v-card-title>
                <h2>{{ article.name_article }}</h2>
            </v-card-title>
            <v-card-text>
                <p>{{ article.text_article }}</p>
                <v-divider></v-divider>

                <h3>Комментарии:</h3>
                <v-list>
                    <v-list-item-group>
                        <v-list-item v-for="comment in article.comments" :key="comment.id">
                            <v-list-item-content>
                                <v-list-item-title>{{ comment.text }}</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list-item-group>
                </v-list>
            </v-card-text>
        </v-card>
        <v-alert v-else-if="error" type="error">{{ error }}</v-alert>
        <v-progress-circular v-if="loading" indeterminate></v-progress-circular>
    </v-container>
</template>

<script>
    import axios from 'axios';

    export default {
        data() {
            return {
                article: null,
                loading: true,
                error: null,
            };
        },
        mounted() {
            this.fetchArticle();
        },
        methods: {
            async fetchArticle() {
                const articleId = this.$route.params.id;
                try {
                    const response = await axios.get(`/api/articles/${articleId}`);
                    if (response.data.status === 'success') {
                        this.article = response.data.article;
                    } else {
                        this.error = response.data.error;
                    }
                } catch (err) {
                    this.error = 'Ошибка при загрузке статьи';
                } finally {
                    this.loading = false;
                }
            },
        },
    };
</script>
