import VueRouter from 'vue-router';
import PatientList from './PatientList';
import PatientDetail from './PatientDetail';

export default new VueRouter({
    mode: 'history',
    routes: [{
            path: '/patient/:id',
            name: 'patient_detail',
            component: PatientDetail
        },
        {
            path: '/patient',
            name: 'patient',
            component: PatientList
        }
    ]
});
