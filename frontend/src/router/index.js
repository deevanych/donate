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
        path: '/donate/:user',
        name: 'donate',
        component: () => import('../views/DonatePage'),
      },
      {
        path: '/widget/:user',
        name: 'widget',
        component: () => import('../views/widgets/Notification'),
      },
    ],
  },
];

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes,
});

export default router;
