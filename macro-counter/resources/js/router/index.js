import { createRouter, createWebHistory } from 'vue-router';

import Home from '../components/Home.vue';
import Tasks from '../components/Tasks.vue';

const routes = [
    { path: '/', component: Home },
    { path: '/tasks', component: Tasks}
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
