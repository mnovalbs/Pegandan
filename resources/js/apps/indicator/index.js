import App from './App';
import router from './router';

export default function install(Vue, store) {
  const el = '#indicators';
  if (!document.querySelector(el)) return;

  new Vue({
    el,
    store,
    router,
    render: h => h(App)
  });
}
