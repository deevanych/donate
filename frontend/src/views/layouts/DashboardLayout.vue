<template>
  <div class="container">
    <div class="row">
      <div class="col">
        <DashboardHeader/>
      </div>
    </div>
    <div class="row">
      <div class="col-3">
        <DashboardSidebar/>
      </div>
      <div class="col">
        <router-view/>
      </div>
    </div>
  </div>
</template>

<script>
import DashboardHeader from '@/views/dashboard/DashboardHeader.vue';
import DashboardSidebar from '@/views/dashboard/DashboardSidebar.vue';

export default {
  name: 'DashboardLayout',
  components: {
    DashboardHeader,
    DashboardSidebar,
  },
};
</script>

<style scoped>

</style>
