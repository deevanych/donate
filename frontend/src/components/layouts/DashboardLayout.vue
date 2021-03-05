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
import DashboardHeader from '@/components/pages/dashboard/DashboardHeaderComponent.vue';
import DashboardSidebar from '@/components/pages/dashboard/DashboardSidebarComponent.vue';

export default {
  name: 'DashboardLayout',
  components: {
    DashboardHeader,
    DashboardSidebar,
  },
};
</script>
