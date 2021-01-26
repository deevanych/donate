import Vue from 'vue';
import VueRouter from 'vue-router';
import store from '@/store';

Vue.use(VueRouter);

const routes = [
  {
    path: '/',
    component: () => import('../views/layouts/MainLayout'),
    beforeEnter: (to, from, next) => {
      if (store.getters.IS_AUTH) {
        const loading = Vue.prototype.$vs.loading();
        store.dispatch('SET_USER').then(() => {
          next();
        }).catch((error) => {
          Vue.prototype.$vs.notification({
            position: 'top-right',
            border: 'danger',
            title: 'Произошла ошибка',
            text: error,
          });
        }).finally(() => {
          loading.close();
        });
      } else if (to.name === 'home') {
        next();
      } else {
        next('/');
      }
    },
    children: [
      {
        path: '',
        name: 'home',
        component: () => import('../views/HomePage'),
      },
      {
        path: 'dashboard',
        component: () => import('../views/layouts/DashboardLayout'),
        children: [
          {
            path: '',
            name: 'dashboard',
            component: () => import('../views/dashboard/DashboardStatsPage'),
          },
          {
            path: 'widgets',
            name: 'widgets',
            component: () => import('../views/dashboard/DashboardWidgetsPage'),
          },
          {
            path: 'settings',
            component: () => import('../views/layouts/MainLayout'),
            children: [
              {
                path: 'donate',
                name: 'settings.donate',
                component: () => import('../views/dashboard/DonationPageSettings'),
              },
            ],
          },
        ],
      },
    ],
  },
  {
    path: '/preview',
    component: () => import('../views/layouts/MainLayout'),
    children: [
      {
        path: 'donate',
        component: () => import('../views/DonatePageTest'),
      },
    ],
  },
  {
    path: '/login',
    name: 'login',
    component: () => import('../views/LoginWindow'),
  },
  {
    path: '/:user',
    alias: '/donate/:user',
    name: 'donate',
    component: () => import('../views/DonatePage'),
  },
  {
    path: '/widget/:user',
    name: 'widget',
    component: () => import('../views/widgets/Notification'),
  },
];

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes,
});

export default router;
