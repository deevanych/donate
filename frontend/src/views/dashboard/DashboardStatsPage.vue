<template>
    <div>
      <router-link :to="{name: 'dashboard'}">stats</router-link>
      <router-link :to="{name: 'widgets'}">widgets</router-link>
    </div>
</template>

<script>
export default {
  name: 'StatsPage',
};
</script>

<style scoped lang="scss">
</style>
