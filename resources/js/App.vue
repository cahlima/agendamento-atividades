<template>
    <div>
      <h1>Atividades Disponíveis</h1>
      <select class="select2" id="dias">
        <option value="segunda">Segunda-feira</option>
        <option value="terca">Terça-feira</option>
        <option value="quarta">Quarta-feira</option>
        <option value="quinta">Quinta-feira</option>
        <option value="sexta">Sexta-feira</option>
      </select>
    </div>
  </template>

  <script>
  import { onMounted } from 'vue';
  import $ from 'jquery';
  import 'select2';

  export default {
    name: 'ExampleComponent',
    setup() {
      onMounted(() => {
        // Inicializa o Select2 quando o componente é montado
        $('.select2').select2();

        $('#dias').select2({
          placeholder: "Selecione os dias",
          allowClear: true
        });
      });
    }
  };
  </script>

  <style scoped>
  /* Seu estilo aqui */
  </style>
