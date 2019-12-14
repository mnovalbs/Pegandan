import VueRouter from 'vue-router';
import IndicatorList from './IndicatorList';
import IndicatorStep from './IndicatorStep';

export default new VueRouter({
    mode: 'history',
    routes: [{
            path: '/indicator/:id/steps',
            name: 'indicator_step',
            component: IndicatorStep
        },
        {
            path: '/indicator',
            name: 'indicator',
            component: IndicatorList
        }
    ]
});
