import { createApp } from 'vue';
import App from './App.vue';
import 'bootstrap/dist/css/bootstrap.css';
import '../sass/app.scss';
import axios from 'axios';
import './bootstrap';
import $ from 'jquery';  // Importa o jQuery

import 'select2';  // Importa o Select2 após o jQuery

// Configuração do Axios
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Configuração do Token CSRF
const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
} else {
    console.error('CSRF token not found');
}

// Inicializa o Vue.js
createApp(App).mount('#vue-app');

// Inicializa o Select2 para o campo de seleção múltipla
$(document).ready(function() {
    $('.select2').select2(); // Inicializa o Select2 em todos os elementos com a classe 'select2'

    $('#dias').select2({
        placeholder: "Selecione os dias",
        allowClear: true
    });
});

// Event Listener para deslogar o usuário ao fechar a aba/janela do navegador
window.addEventListener('beforeunload', function (e) {
    navigator.sendBeacon('/logout', '');
});
