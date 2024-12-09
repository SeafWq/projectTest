<template>
    <v-container class="d-flex align-content-space-around flex-wrap" style="width: 1200px">
        <v-row justify="center">
            <v-col
                v-for="article in articles" :key="article.id"
                cols="12" sm="4"
                style="padding: 13px;"
            >
                <v-card class="mx-auto" max-width="344">
                    <v-img
                        height="200px"
                        :src="article.image_path ? article.image_path : 'https://cdn.vuetifyjs.com/images/cards/sunshine.jpg'"
                        cover
                    ></v-img>

                    <v-card-title>
                        <h2>{{ article.name_article }}</h2>
                    </v-card-title>

                    <v-card-subtitle>
                        <v-icon icon="mdi-eye"></v-icon> {{ article.watch_count }}
                        <v-icon
                            icon="mdi-comment-outline" style="cursor: pointer"></v-icon>{{ article.comments_count }}
                        <v-icon  :color="article.liked ? 'pink' : 'gray'"
                                 @click="like(article)"
                                 style="cursor: pointer;"
                                 icon="mdi-heart-outline">
                        </v-icon>{{ article.likes_count }}
                    </v-card-subtitle>
                    <v-card-text>
                        {{truncateText(article.text_article, 100)}}
                    </v-card-text>
                    <v-card-actions>
                        <v-btn
                            :to="`/articles/${article.id}`"
                            color="orange-lighten-2"
                            text="Посмотреть"
                        ></v-btn>

                        <v-spacer></v-spacer>
                    </v-card-actions>

                </v-card>
            </v-col>
        </v-row>
        <v-row no-gutters>
            <v-col>
                <v-sheet class="pa-4 ma-10">
                </v-sheet>
                <div v-if="loading" class="loading">Загрузка...</div>
            </v-col>
        </v-row>
    </v-container>
</template>


<script>
    import axios from '/resources/js/config/axios';

    export default {
        name: 'Main',
        data() {
            return {
                likedArticles: new Set(),
                show: false,
                articles: [],
                page: 1,
                loading: false,
                allLoaded: false,
            };
        },
        mounted() {
            this.loadArticles();
            window.addEventListener('scroll', this.handleScroll);
        },
        beforeDestroy() {
            window.removeEventListener('scroll', this.handleScroll);
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

                    article.likes_count = response.data.likeCount;
                    article.liked = !article.liked;
                } catch (error) {
                    console.error('Ошибка при добавлении/удалении лайка:', error);
                }
            },
            truncateText(text, length) {
                if (text.length > length) {
                    return text.substring(0, length) + '...';
                }
                return text;
            },
            loadArticles() {
                if (this.loading || this.allLoaded) return;
                this.loading = true;

                axios.get(`/api/articles?page=${this.page}`)
                    .then(response => {
                        if (response.data.status === 'success') {
                            const newArticles = response.data.articles.data;

                            newArticles.forEach(article => {
                                article.liked = article.liked || false;
                            });

                            if (newArticles.length === 0) {
                                this.allLoaded = true;
                            } else {
                                this.articles.push(...newArticles);
                                this.page++;
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Ошибка при загрузке статей:', error);
                    })
                    .finally(() => {
                        this.loading = false;
                    });
            },
            handleScroll() {
                if (window.scrollY + window.innerHeight >= document.body.offsetHeight - 100) {
                    this.loadArticles();
                }
            },
        },
    };
</script>

<style scoped>
    .body{
        width: 1202px;
    }
    .loading {
        text-align: center;
        margin: 20px 0;
    }

</style>
