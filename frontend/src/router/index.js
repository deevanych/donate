import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

const routes = [
  {
    path: '/',
    component: () => import('../components/layouts/MainLayout'),
    children: [
      {
        path: '',
        name: 'home',
        component: () => import('../components/pages/HomePageComponent'),
      },
      {
        path: 'dashboard',
        component: () => import('../components/layouts/DashboardLayout'),
        children: [
          {
            path: '',
            name: 'dashboard.index',
            component: () => import('../components/pages/dashboard/index/DashboardIndexPageComponent'),
          },
          {
            path: 'widgets',
            name: 'dashboard.widgets.list',
            component: () => import('../components/pages/dashboard/widgets/DashboardWidgetsPageComponent'),
          },
          {
            path: 'settings',
            component: () => import('../components/layouts/MainLayout'),
            children: [
              {
                path: 'donation-page',
                name: 'dashboard.settings.donationPage',
                component: () => import('../components/pages/dashboard/DashboardDonationPageSettingsComponent'),
              },
            ],
          },
        ],
      },
    ],
  },
  {
    path: '/login',
    name: 'login',
    component: () => import('../components/LoginWindowComponent'),
  },
  {
    path: '/:user',
    alias: '/donate/:user',
    name: 'donate',
    component: () => import('../components/layouts/DonatePageLayout'),
  },
  {
    path: '/donations-page?type=preview',
    component: () => import('../components/layouts/DonatePageLayout'),
  },
  {
    path: '/widget',
    name: 'obs.widgets',
    component: () => import('../components/layouts/widgets/WidgetsLayout'),
    children: [
      {
        path: 'stats/:id',
        name: 'obs.widget.stats',
        component: () => import('../components/layouts/widgets/StatsWidgetLayout'),
      },
      {
        path: 'media/:id',
        name: 'obs.widget.media',
        component: () => import('../components/layouts/widgets/MediaWidgetLayout'),
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
