import VueRouter from 'vue-router';
import IndicatorList from './IndicatorList';

export default new VueRouter({
    routes: [{
        path: '/',
        name: 'indicator',
        component: IndicatorList
    }]
});
