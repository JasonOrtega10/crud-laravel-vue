<template>
    <div>
        <h1>CRUD con Laravel y Vue.js</h1>

        <!-- Formulario para crear un nuevo post -->
        <form @submit.prevent="createPost">
            <div>
                <label for="title">Título:</label>
                <input type="text" v-model="newPost.title" id="title" required />
            </div>
            <div>
                <label for="content">Contenido:</label>
                <textarea v-model="newPost.content" id="content" required></textarea>
            </div>
            <button type="submit">Crear Post</button>
        </form>

        <!-- Lista de posts -->
        <div v-if="posts.length">
            <h2>Posts</h2>
            <ul>
                <li v-for="post in posts" :key="post.id">
                    <h3>{{ post.title }}</h3>
                    <p>{{ post.content }}</p>
                    <button @click="editPost(post)">Editar</button>
                    <button @click="deletePost(post.id)">Eliminar</button>
                </li>
            </ul>
        </div>
        <div v-else>
            <p>No hay posts disponibles.</p>
        </div>

        <!-- Formulario para editar un post -->
        <div v-if="editingPost">
            <h2>Editar Post</h2>
            <form @submit.prevent="updatePost">
                <div>
                    <label for="editTitle">Título:</label>
                    <input type="text" v-model="editingPost.title" id="editTitle" required />
                </div>
                <div>
                    <label for="editContent">Contenido:</label>
                    <textarea v-model="editingPost.content" id="editContent" required></textarea>
                </div>
                <button type="submit">Actualizar Post</button>
                <button @click="cancelEdit">Cancelar</button>
            </form>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            posts: [],
            newPost: {
                title: '',
                content: ''
            },
            editingPost: null
        };
    },
    methods: {
        fetchPosts() {
            axios.get('/api/posts')
                .then(response => this.posts = response.data)
                .catch(error => console.error('Error fetching posts:', error));
        },
        createPost() {
            axios.post('/api/posts', this.newPost)
                .then(() => {
                    this.newPost.title = '';
                    this.newPost.content = '';
                    this.fetchPosts();
                })
                .catch(error => console.error('Error creating post:', error));
        },
        editPost(post) {
            this.editingPost = { ...post };
        },
        updatePost() {
            axios.put(`/api/posts/${this.editingPost.id}`, this.editingPost)
                .then(() => {
                    this.editingPost = null;
                    this.fetchPosts();
                })
                .catch(error => console.error('Error updating post:', error));
        },
        deletePost(postId) {
            axios.delete(`/api/posts/${postId}`)
                .then(() => this.fetchPosts())
                .catch(error => console.error('Error deleting post:', error));
        },
        cancelEdit() {
            this.editingPost = null;
        }
    },
    mounted() {
        this.fetchPosts();
    }
}
</script>

<style scoped>
/* Agrega tus estilos aquí */
form {
    margin-bottom: 20px;
}
form div {
    margin-bottom: 10px;
}
</style>
