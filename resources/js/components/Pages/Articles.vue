<template>
    <v-container class="d-flex flex-column align-center" style="width: 1200px;">
        <v-row class="w-100">
            <v-col
                v-for="article in articles" :key="article.id"
                class="d-flex justify-center"
                style="width: 100%;"
            >
                <v-card class="ma-2" style="width: 1200px; height: 600px;">
                    <v-img
                        height="340px"
                    src="https://cdn.vuetifyjs.com/images/cards/sunshine.jpg"
                    cover
                    ></v-img>

                    <v-card-title>
                        <h2>{{ article.name_article }}</h2>
                    </v-card-title>

                    <v-card-subtitle>
                        <v-icon icon="mdi-eye"></v-icon> {{ article.watch_count }}
                        <v-icon icon="mdi-comment-outline"></v-icon>{{ article.comment_count }}
                        <v-icon icon="mdi-heart-outline"></v-icon>{{ article.like_count }}

                    </v-card-subtitle>
                    <v-expand-transition>
                        <v-card-text>
                            {{truncateText(article.text_article, 500)}}
                        </v-card-text>
                    </v-expand-transition>

                    <v-card-actions>
                        <v-btn
                            :to="`/articles/${article.id}`"
                            color="orange-lighten-2"
                            text="Посмотреть"
                        ></v-btn>
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
    import axios from 'axios';

    export default {
        name: 'Articles',
        data() {
            return {
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
