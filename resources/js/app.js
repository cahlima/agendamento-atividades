import { createApp } from 'vue';
import App from './App.vue';

// Configuração do Token CSRF
const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token;

createApp(App).mount('#vue-app');

// Event Listener para deslogar o usuário ao fechar a aba/janela do navegador
window.addEventListener('beforeunload', function (e) {
    navigator.sendBeacon('/logout', '');
});
