<template>
  <div/>
</template>

<script>
export default {
  name: 'LoginWindow',
  created() {
    if (this.$route.query.token) {
      localStorage.setItem('_token', this.$route.query.token || null);
    }
    window.close();
  },
};
</script>

<style scoped>

</style>
