
import './bootstrap.js';

import Vue from 'vue';

import { createApp } from 'vue';
import App from './components/App.vue';
import ExampleComponent from './components/ExampleComponent.vue';




// Component registration
const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => {
    Vue.component(key.split('/').pop().split('.')[0], files(key).default);
});

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

// Create Vue instance
const app = createApp(App);
app.mount('#app');
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


