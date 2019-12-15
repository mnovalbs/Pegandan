import App from './App';

export default function install(Vue, store) {
  const el = '#kelurahan-app';
  if (!document.querySelector(el)) return;

  new Vue({
    el,
    render: h => h(App)
  });
}
