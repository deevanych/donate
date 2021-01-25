import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

const routes = [
  {
    path: '/',
    component: () => import('../views/layouts/MainLayout'),
    children: [
      {
        path: '/',
        name: 'home',
        component: () => import('../views/HomePage'),
      },
      {
        path: '/widget/:user',
        name: 'widget',
        component: () => import('../views/widgets/Notification'),
      },
    ],
  },
  {
    path: '/login',
    name: 'login',
    component: () => import('../views/LoginWindow'),
  },
  {
    path: '/dashboard',
    name: 'dashboard',
    component: () => import('../views/DashboardPage'),
  },
  {
    path: '/:user',
    alias: '/donate/:user',
    name: 'donate',
    component: () => import('../views/DonatePage'),
  },
];

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes,
});

export default router;
