import { createApp } from 'vue';
import { setDefaultHeaders } from './utils/fetchJson';
import App from './App.vue';
import '../css/app.css'
import '@fontsource/poppins/400.css';
import '@fontsource/poppins/600.css';
import '@fontsource/poppins/700.css';
import '@fontsource/inter/400.css';
import '@fontsource/inter/500.css';
import '@fontsource/inter/600.css';


// Configuration des headers CSRF
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
if (csrfToken) {
  setDefaultHeaders({
    'X-CSRF-TOKEN': csrfToken
  });
}

// Création de l'application Vue
const app = createApp(App);
app.mount('#app');
