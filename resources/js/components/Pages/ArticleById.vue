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
                <div class="mt-3 d-flex justify-end">
                    <v-icon class="ml-3" icon="mdi-eye"></v-icon> {{ article.watch_count }}
                    <v-icon  :color="article.liked ? 'pink' : 'gray'"
                             @click="like(article)"
                             style="cursor: pointer;"
                             icon="mdi-heart-outline">
                    </v-icon>{{ article.like_count }}
                </div>
                <v-divider></v-divider>
                <h2>Оставить комментарий</h2>
                <v-textarea
                    label="Сообщение"
                    row-height="30"
                    rows="4"
                    variant="filled"
                    auto-grow
                    shaped
                    prepend-icon="mdi-comment"
                ></v-textarea>
                <v-divider></v-divider>
                <h3>Комментарии: <v-icon class="ml-3" icon="mdi-comment-outline"></v-icon>{{ article.comment_count }}</h3>
                <v-list>
                    <v-list-item-group>
                        <v-list-item v-for="comment in article.comments" :key="comment.id">
                            <v-list-item-content>
                                <v-list-item-title>{{ comment.text }}</v-list-item-title>
                                <v-list-item-subtitle>
                                    <span class="grey--text">{{ formatDate(comment.created_at) }}</span>
                                </v-list-item-subtitle>
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
            const token = localStorage.getItem('token');
            if (token) {
                axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
            }
            this.fetchArticle();
        },
        methods: {
            async like(article) {
                const token = localStorage.getItem('token');
                if (!token) {
                    alert('Пожалуйста, войдите в систему, чтобы поставить лайк.');
                    return;
                }

                try {
                    const response = await axios.post('/api/likes', {
                        article_id: article.id,
                    });
                    article.like_count = response.data.likeCount;
                    article.liked = !article.liked;
                } catch (error) {
                    console.error('Ошибка при добавлении/удалении лайка:', error);
                }
            },
            async fetchArticle() {
                const articleId = this.$route.params.id;
                try {
                    const response = await axios.get(`/api/articles/${articleId}`);
                    if (response.data.status === 'success') {
                        this.article = response.data.article;
                        this.article.liked = response.data.liked;
                        this.article.like_count = response.data.like_count;
                    } else {
                        this.error = response.data.error;
                    }
                } catch (err) {
                    this.error = 'Ошибка при загрузке статьи';
                } finally {
                    this.loading = false;
                }
            },
            formatDate(dateString) {
                const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
                return new Date(dateString).toLocaleDateString('ru-RU', options); // Форматируем дату
            },
        },
    };
</script>

<style scoped>
    .v-list-item {
        border-bottom: 1px solid #e0e0e0;
        padding: 10px 0;
    }

    .v-list-item-title {
        font-weight: bold;
    }

    .v-list-item-subtitle {
        font-size: 0.875rem;
        color: #757575;
    }
</style>
