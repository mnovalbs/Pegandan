import VueRouter from 'vue-router';
import ReportApp from './ReportApp';
import ReportDashboard from './ReportDashboard';

export default new VueRouter({
    mode: 'history',
    routes: [{
            path: '/report',
            name: 'report_detail',
            component: ReportApp
        }, {
            path: '/home',
            name: 'dashboard',
            component: ReportDashboard
        },
    ]
});
