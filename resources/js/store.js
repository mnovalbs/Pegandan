import Vuex from 'vuex';
import API from './interface';

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
    },

    actions: {
      async fetchIndicators({ commit }) {
        const { data } = await API.indicators.list();
        commit('setIndicators', data.data);
      }
    }
  });

  return store;
};