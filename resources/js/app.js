// import './bootstrap';
import Vue from 'vue';
import Vuex from 'vuex';
import VueRouter from 'vue-router';
import BootstrapVue from 'bootstrap-vue';
import installStore from './store';

import '../sass/app.scss';
import 'bootstrap-vue/dist/bootstrap-vue.css'

Vue.use(BootstrapVue);
Vue.use(Vuex);
Vue.use(VueRouter);

const store = installStore(Vue);

import patientInstall from './apps/patient';
import navIndicatorInstall from './apps/nav-indicator';
import indicatorInstall from './apps/indicator';

patientInstall(Vue, store);
navIndicatorInstall(Vue, store);
indicatorInstall(Vue, store);