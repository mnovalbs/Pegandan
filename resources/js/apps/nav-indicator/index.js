import App from './App';
import installStore from '../../store';


export default function install(Vue) {
  const el = '#nav-indicators';
  if (!document.querySelector(el)) return;
  
  const store = installStore(Vue);
  new Vue({
    el,
    store,
    render: h => h(App)
  });
}
