// import './bootstrap';
import Vue from 'vue';
import Vuex from 'vuex';
import BootstrapVue from 'bootstrap-vue';

import '../sass/app.scss';
import 'bootstrap-vue/dist/bootstrap-vue.css'

Vue.use(BootstrapVue);
Vue.use(Vuex);

import patientInstall from './apps/patient';
import navIndicatorInstall from './apps/nav-indicator';

patientInstall(Vue);
navIndicatorInstall(Vue);