import App from './App';

export default function install(Vue) {
  const el = '#report';
  if (!document.querySelector(el)) return;

  new Vue({
    el,
    render: h => h(App)
  });
}
