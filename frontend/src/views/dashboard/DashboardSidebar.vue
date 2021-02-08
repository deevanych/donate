<template>
  <vs-sidebar
    :notLineActive="true"
    :value="$route.name"
    class="shadow-none"
    open
    relative
  >
    <template #logo>
      <!-- ...img logo -->
    </template>
    <vs-sidebar-item id="dashboard.index" :to="{name: 'dashboard.index'}">
      <template #icon>
        <i class='bx bx-home'></i>
      </template>
      Главная
    </vs-sidebar-item>
    <vs-sidebar-item id="dashboard.widgets.list" :to="{name: 'dashboard.widgets.list'}">
      <template #icon>
        <i class='bx bx-grid-alt'></i>
      </template>
      Виджеты
    </vs-sidebar-item>
    <vs-sidebar-item id="dashboard.settings.donationPage" :to="{name: 'dashboard.settings.donationPage'}">
      <template #icon>
        <i class='bx bxs-donate-heart'></i>
      </template>
      Страница доната
    </vs-sidebar-item>
    <vs-sidebar-item id="finance" to="/">
      <template #icon>
        <i class='bx bx-dollar-circle'></i>
      </template>
      Финансы
    </vs-sidebar-item>
  </vs-sidebar>
</template>

<script>
export default {
  name: 'DashboardSidebar',
};
</script>

<style scoped>

</style>
