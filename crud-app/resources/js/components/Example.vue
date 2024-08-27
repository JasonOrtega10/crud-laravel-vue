<template>
    <div class="container">
        <h1 class="title">CRUD con Laravel y Vue.js</h1>

        <!-- Formulario para crear un nuevo post -->
        <form @submit.prevent="createPost" class="form">
            <div class="form-group">
                <label for="title">Título:</label>
                <input type="text" v-model="newPost.title" id="title" required class="input" />
            </div>
            <div class="form-group">
                <label for="content">Contenido:</label>
                <textarea v-model="newPost.content" id="content" required class="textarea"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Crear Post</button>
        </form>

        <!-- Lista de posts -->
        <div v-if="posts.length" class="posts">
            <h2 class="subtitle">Posts</h2>
            <ul class="post-list">
                <li v-for="post in posts" :key="post.id" class="post-item">
                    <h3 class="post-title">{{ post.title }}</h3>
                    <p class="post-content">{{ post.content }}</p>
                    <div class="post-actions">
                        <button @click="editPost(post)" class="btn btn-warning">Editar</button>
                        <button @click="deletePost(post.id)" class="btn btn-danger">Eliminar</button>
                    </div>
                </li>
            </ul>
        </div>
        <div v-else class="no-posts">
            <p>No hay posts disponibles.</p>
        </div>

        <!-- Formulario para editar un post -->
        <div v-if="editingPost" class="form">
            <h2 class="subtitle">Editar Post</h2>
            <form @submit.prevent="updatePost">
                <div class="form-group">
                    <label for="editTitle">Título:</label>
                    <input type="text" v-model="editingPost.title" id="editTitle" required class="input" />
                </div>
                <div class="form-group">
                    <label for="editContent">Contenido:</label>
                    <textarea v-model="editingPost.content" id="editContent" required class="textarea"></textarea>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Actualizar Post</button>
                    <button @click="cancelEdit" class="btn btn-secondary">Cancelar</button>
                </div>
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
.container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.title {
    font-size: 2rem;
    text-align: center;
    margin-bottom: 20px;
    color: #333;
}

.subtitle {
    font-size: 1.5rem;
    margin-bottom: 10px;
    color: #555;
}

.form {
    background-color: #fff;
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 5px;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
}

.form-group {
    margin-bottom: 15px;
}

.input,
.textarea {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 1rem;
}

.textarea {
    resize: none;
    height: 100px;
}

.btn {
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 1rem;
}

.btn-primary {
    background-color: #007bff;
    color: #fff;
}

.btn-primary:hover {
    background-color: #0056b3;
}

.btn-secondary {
    background-color: #6c757d;
    color: #fff;
}

.btn-secondary:hover {
    background-color: #5a6268;
}

.btn-warning {
    background-color: #ffc107;
    color: #212529;
}

.btn-warning:hover {
    background-color: #e0a800;
}

.btn-danger {
    background-color: #dc3545;
    color: #fff;
}

.btn-danger:hover {
    background-color: #c82333;
}

.posts {
    margin-top: 20px;
}

.post-list {
    list-style-type: none;
    padding: 0;
}

.post-item {
    padding: 15px;
    margin-bottom: 15px;
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
}

.post-title {
    font-size: 1.25rem;
    margin-bottom: 10px;
    color: #333;
}

.post-content {
    margin-bottom: 15px;
    color: #555;
}

.post-actions {
    display: flex;
    gap: 10px;
}

.no-posts {
    text-align: center;
    color: #777;
    margin-top: 20px;
}

.form-actions {
    display: flex;
    justify-content: space-between;
    margin-top: 15px;
}
</style>
