// import './bootstrap';
import Vue from 'vue';
import Vuex from 'vuex';
import VueRouter from 'vue-router';
import VueSelect from 'vue-select';
import BootstrapVue from 'bootstrap-vue';
import installStore from './store';

import patientInstall from './apps/patient';
import navIndicatorInstall from './apps/nav-indicator';
import indicatorInstall from './apps/indicator';
import reportInstall from './apps/report';

import '../sass/app.scss';
import 'bootstrap-vue/dist/bootstrap-vue.css'

Vue.use(BootstrapVue);
Vue.use(Vuex);
Vue.use(VueRouter);
Vue.component('v-select', VueSelect);

const store = installStore(Vue);

patientInstall(Vue, store);
navIndicatorInstall(Vue, store);
indicatorInstall(Vue, store);
reportInstall(Vue, store);