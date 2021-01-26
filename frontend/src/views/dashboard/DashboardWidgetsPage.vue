<template>
  <div>
    <router-link :to="{name: 'dashboard'}">stats</router-link>
    <router-link :to="{name: 'widgets'}">widgets</router-link>
  </div>
</template>

<script>
export default {
  name: 'WidgetsPage',
};
</script>

<style scoped>

</style>
