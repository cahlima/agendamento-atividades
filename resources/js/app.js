import { createApp } from 'vue';
import App from './App.vue';
import 'bootstrap/dist/css/bootstrap.css';
import '../sass/app.scss';
import axios from 'axios';
import $ from 'jquery';  // Importa o jQuery
import 'select2';  // Importa o Select2 após o jQuery

// Configuração do Axios
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.withCredentials = true; // Inclui cookies e autenticação automaticamente


// Configuração do Token CSRF
const csrfToken = document.querySelector('meta[name="csrf-token"]');
if (csrfToken) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken.getAttribute('content');
} else {
    console.error('CSRF token not found');
}

// Inicializa o Vue.js
createApp(App).mount('#vue-app');

// Inicialize o select2
$(document).ready(function() {
    $('#atividade').select2({
        placeholder: "{{ __('Selecione uma atividade') }}",
        allowClear: true
    });
});

// Event Listener para deslogar o usuário ao fechar a aba/janela do navegador
window.addEventListener('beforeunload', function () {
    navigator.sendBeacon('/logout', '');
});

// Função para buscar horários via AJAX
function buscarHorarios(atividadeId) {
    console.log('Atividade ID:', atividadeId); // Verifique se o ID está correto
    if (atividadeId) {
        fetch(`/aluno/atividades/${atividadeId}/horarios`)
            .then(response => response.json())
            .then(data => {
                console.log('Dados recebidos:', data); // Verifique os dados recebidos
                var horariosList = document.getElementById('horarios-list');
                horariosList.innerHTML = ''; // Limpa a lista de horários

                if (data.length > 0) {
                    data.forEach(horario => {
                        var li = document.createElement('li');
                        li.className = 'list-group-item';
                        li.textContent = horario.hora;
                        horariosList.appendChild(li);
                    });
                    document.getElementById('horarios-disponiveis').style.display = 'block';
                    document.getElementById('atividades-dinamicas').style.display = 'block'; // Exibe a tabela de atividades
                } else {
                    document.getElementById('horarios-disponiveis').style.display = 'none';
                    document.getElementById('atividades-dinamicas').style.display = 'none'; // Esconde a tabela se não houver horários
                }
            })
            .catch(error => {
                console.error('Erro ao buscar horários:', error);
                alert('Ocorreu um erro ao buscar os horários. Por favor, tente novamente.');
                document.getElementById('horarios-disponiveis').style.display = 'none';
                document.getElementById('atividades-dinamicas').style.display = 'none'; // Esconde a tabela em caso de erro
            });
    } else {
        document.getElementById('horarios-disponiveis').style.display = 'none';
        document.getElementById('atividades-dinamicas').style.display = 'none'; // Esconde a tabela se nenhuma atividade for selecionada
    }
}


// Configurar o modal de confirmação
document.getElementById('confirmModal').addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;
    var atividadeId = button.getAttribute('data-id');
    var atividadeNome = button.getAttribute('data-atividade');
    var atividadeHora = button.getAttribute('data-hora');

    var confirmMessage = document.getElementById('confirmMessage');
    confirmMessage.textContent = `Você está se matriculando na atividade "${atividadeNome}" às ${atividadeHora}. Podemos confirmar?`;

    var confirmBtn = document.getElementById('confirmBtn');
    confirmBtn.onclick = function() {
        confirmBtn.disabled = true;
        var form = document.createElement('form');
        form.method = 'POST';
        form.action = `/aluno/atividades/matricular/${atividadeId}`;

        var csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = `{{ csrf_token() }}`;

        form.appendChild(csrfInput);
        document.body.appendChild(form);
        form.submit();
    };
});
