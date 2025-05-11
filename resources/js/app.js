import { createApp } from 'vue';
import { setDefaultHeaders } from '@/utils/fetchJson.js';
import App from './App.vue';
import '../css/app.css'


// Configuration des headers CSRF
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '';
setDefaultHeaders({'X-CSRF-TOKEN': csrfToken});

// Création de l'application Vue
const app = createApp(App);
app.mount('#app');
