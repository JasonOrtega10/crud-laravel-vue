import './bootstrap';

import { createApp } from 'vue';
import Apps from './components/App.vue';
import Example from './components/Example.vue';

// Crear la aplicación Vue
const app = createApp({});

// Registrar componentes globales
app.component('example', Example);

// Montar la aplicación Vue en el div con id 'app'
app.mount('#app');