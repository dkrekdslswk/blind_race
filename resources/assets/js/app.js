import Vue from 'vue';
import VueSocketio from 'vue-socket.io';
import socketio from 'socket.io-client';
Vue.use(VueSocketio, socketio(':8890'));


import BootstrapVue from 'bootstrap-vue'
Vue.use(BootstrapVue);

require('./bootstrap');

import VueRouter from 'vue-router';
Vue.use(VueRouter);

import VueAxios from 'vue-axios';
import axios from 'axios';
Vue.use(VueAxios, axios);

import App from './App.vue';
import Example from './components/Example.vue';
import Login from './components/Login.vue';
import Footer from './components/Footer.vue';
import Modal from './components/Modal.vue';
import AJH from './components/AJH.vue';
import chat from './components/chat.vue';
const routes = [
  {  path: '/chat',  component: chat },
  {  path: '/login', component: Login   },
  {  path: '/',      component :Footer },
  {  path: '/',      component :Modal  },
  {  path: '/AJH',      component :AJH }
];

const router = new VueRouter({ mode: 'history', routes: routes});
new Vue(Vue.util.extend({ router }, App)).$mount('#app');
