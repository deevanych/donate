<template>
  <div/>
</template>

<script>
export default {
  name: 'LoginWindow',
  created() {
    if (this.$route.query.token) {
      localStorage.setItem('_token', this.$route.query.token || null);
      this.$store.dispatch('SET_TOKEN', this.$route.query.token);
    }
    this.$router.push('dashboard');
  },
};
</script>

<style scoped>

</style>
