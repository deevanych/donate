<template>
  <nav>
    <li>
      <router-link :to="{name: 'dashboard.index'}">Главная</router-link>
    </li>
    <li>
      <router-link :to="{name: 'dashboard.widgets.list'}">Виджеты</router-link>
    </li>
    <li>
      <router-link :to="{name: 'dashboard.settings.donationPage'}">Страница доната</router-link>
    </li>
  </nav>
</template>

<script>
export default {
  name: 'DashboardSidebar',
};
</script>

<style scoped>

</style>
