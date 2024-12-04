<template>
    <div id="articles-container">
        <div v-for="article in articles" :key="article.id" class="article">
            <h2>{{ article.text_article }}</h2>
            <p>Likes: {{ article.likes_count }}</p>
            <p>Comments: {{ article.comment_count }}</p>
        </div>
        <div v-if="loading" class="loading">Загрузка...</div>
    </div>
</template>


<script>
    import axios from 'axios';

    export default {
        name: 'Articles',
        data() {
            return {
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
    .loading {
        text-align: center;
        margin: 20px 0;
    }
</style>
