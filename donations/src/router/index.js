import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

const routes = [
  {
    path: '/',
    component: () => import('../components/layouts/MainLayout'),
    children: [
      {
        path: '/',
        name: 'home',
        component: () => import('../components/pages/Home'),
      },
      {
        path: '/donate/:user',
        name: 'donate',
        component: () => import('../components/pages/Donate'),
      },
      {
        path: '/widget/:user',
        name: 'widget',
        component: () => import('../components/widgets/Notification'),
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
