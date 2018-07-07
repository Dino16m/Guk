// app.js

require('./bootstrap');

window.Vue = require('vue');

Vue.component('example', require('./components/ExampleComponent.vue'));

const app = new Vue({
    el: '#app'
});
import Vue from 'vue';

import VueRouter from 'vue-router';
Vue.use(VueRouter);

import VueAxios from 'vue-axios';
import axios from 'axios';
Vue.use(VueAxios, axios);

const router = new VueRouter({ mode: 'history'});
new Vue(Vue.util.extend({ router })).$mount('#app');

import App from './App.vue';

new Vue(Vue.util.extend({ router }, App)).$mount('#app');