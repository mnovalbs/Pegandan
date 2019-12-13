import Vuex from 'vuex';

export default function install(Vue){
  Vue.use(Vuex);

  const store = new Vuex.Store({
    state: {
      indicators: []
    },
  
    mutations: {
      setIndicators(state, indicators) {
        state.indicators = indicators;
      }
    }
  });

  return store;
};