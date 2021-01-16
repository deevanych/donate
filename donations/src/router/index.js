import { createRouter, createWebHistory } from 'vue-router';
import CreateDonation from '@/views/donations/CreateDonation.vue';
import App from '@/App.vue';
import Home from '@/views/Home.vue';

const routes = [
  {
    path: '/',
    name: 'App',
    component: App,
    children: [
      {
        path: '/',
        name: 'Home',
        component: Home,
      },
      {
        path: 'donate',
        name: 'CreateDonation',
        component: CreateDonation,
      },
    ],
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
