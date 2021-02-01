import Vue from 'vue';
import VueRouter from 'vue-router';
import store from '../store/index';

Vue.use(VueRouter);

const routes = [
  {
    path: '/',
    component: () => import('../views/layouts/MainLayout'),
    beforeEnter: (to, from, next) => {
      if (store.getters.IS_AUTH) {
        const loading = Vue.prototype.$vs.loading();
        store.dispatch('GET_USER').then(() => {
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
            name: 'dashboard.index',
            component: () => import('../views/dashboard/DashboardIndexPage'),
          },
          {
            path: 'widgets',
            name: 'dashboard.widgets.list',
            component: () => import('../views/dashboard/widgets/DashboardWidgetsPage'),
          },
          {
            path: 'widgets/:id',
            name: 'dashboard.widgets.edit',
            component: () => import('../views/dashboard/widgets/DashboardWidgetsEditPage'),
          },
          {
            path: 'settings',
            component: () => import('../views/layouts/MainLayout'),
            children: [
              {
                path: 'donation-page',
                name: 'dashboard.settings.donationPage',
                component: () => import('../views/dashboard/DashboardDonationPageSettings'),
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
    path: '/auth/twitch',
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
    path: '/widget/media',
    name: 'obs.widget',
    component: () => import('../views/widgets/MediaWidget'),
  },
  {
    path: '/widget/notification/:user',
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
