import App from './App';
import router from './router';

export default function install(Vue) {
  const el = '#patient';
  if (!document.querySelector(el)) return;

  new Vue({
    el,
    router,
    render: h => h(App)
  });
}
