import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

const routes = [
  {
    path: '/',
    component: () => import('../views/layouts/MainLayout'),
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
    path: '/widget',
    name: 'obs.widgets',
    component: () => import('../views/layouts/MainLayout'),
    children: [
      {
        path: 'stats/:id',
        name: 'obs.widget.stats',
        component: () => import('../views/layouts/widgets/StatsWidgetLayout'),
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
