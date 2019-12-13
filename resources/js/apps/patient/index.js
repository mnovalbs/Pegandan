import App from './App';

export default function install(Vue) {
  const el = '#patient';
  if (!document.querySelector(el)) return;

  new Vue({
    el,
    render: h => h(App)
  });
}
