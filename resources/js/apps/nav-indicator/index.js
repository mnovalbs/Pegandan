import App from './App';

export default function install(Vue, store) {
  const el = '#nav-indicators';
  if (!document.querySelector(el)) return;
  
  new Vue({
    el,
    store,
    render: h => h(App)
  });
}
