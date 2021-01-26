<template>
  <nav>
    <li>
      <router-link :to="{name: 'dashboard'}">Главная</router-link>
    </li>
    <li>
      <router-link :to="{name: 'settings.donate'}">Страница доната</router-link>
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
