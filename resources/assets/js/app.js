
import Vue from 'vue';
import VueSocketio from 'vue-socket.io';
import socketio from 'socket.io-client';
Vue.use(VueSocketio, socketio(':8890'));

     
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import VueAxios from 'vue-axios';
import axios from 'axios';
Vue.use(VueAxios, axios);

import App from './App.vue';
import Example from './components/Example.vue';
import Main from './components/Main.vue';


const routes = [
  { name: 'Main', path: '/', component: Main },
  { name: 'Example', path: '/chat', component: Example }
];

const router = new VueRouter({ mode: 'history', routes: routes});
new Vue(Vue.util.extend({ router }, App)).$mount('#app');

