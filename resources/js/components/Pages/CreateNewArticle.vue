<template>
    <div class="container">
        <div>
            <v-text-field
                v-model="nameArticle"
                label="Название поста"
                required
            ></v-text-field>
            <v-textarea label="Текст поста" v-model="textArticle"></v-textarea>
            <v-file-input
                v-model="imagePath"
                type="file"
                label="Загрузите изображение"
                prepend-icon="mdi-camera"
                variant="filled"
                @update:modelValue="onFileChange"
            ></v-file-input>
            <v-btn @click="submitArticle">Создать статью</v-btn>
        </div>
    </div>
</template>

<script>
    import axios from '/resources/js/config/axios'
    export default {
        name: "CreateNewArticle",
        data: () => ({
            nameArticle: '',
            imagePath: '',
            textArticle: ''
        }),
        methods: {
            onFileChange(file) {
                this.imagePath = file;
            },
            async submitArticle() {
                const formData = new FormData();
                formData.append('nameArticle', this.nameArticle);
                formData.append('textArticle', this.textArticle);
                formData.append('imagePath', this.imagePath);

                try {
                    const response = await axios.post('/api/article/create', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    });
                    console.log('Статья успешно создана', response.data);
                } catch (error) {
                    console.error('Ошибка при создании статьи:', error);
                }
            }
        }

    }
</script>

<style scoped>

    .container{
        width: 1200px;
    }
</style>
