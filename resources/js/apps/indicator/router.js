import VueRouter from 'vue-router';
import IndicatorList from './IndicatorList';
import IndicatorStep from './IndicatorStep';
import IndicatorDetail from './IndicatorDetail';

export default new VueRouter({
    mode: 'history',
    routes: [{
            path: '/indicator/:id',
            name: 'indicator_detail',
            component: IndicatorDetail
        }, {
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
