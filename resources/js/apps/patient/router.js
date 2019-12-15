import VueRouter from 'vue-router';
import PatientList from './PatientList';

export default new VueRouter({
    mode: 'history',
    routes: [{
            path: '/patient/:id',
            name: 'patient_detail',
            component: PatientList
        },
        {
            path: '/patient',
            name: 'patient',
            component: PatientList
        }
    ]
});
