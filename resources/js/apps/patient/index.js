import Vue from 'vue';
import BootstrapVue from 'bootstrap-vue';
import App from './App';

Vue.use(BootstrapVue);

new Vue({
  el: '#patient',
  render: h => h(App)
});