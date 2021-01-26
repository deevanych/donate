<template>
  <div>
    Авторизация успешна
    {{ token }}
  </div>
</template>

<script>
export default {
  name: 'LoginWindow',
  data() {
    return {
      token: null,
    };
  },
  mounted() {
    this.token = this.$route.query.token;
    localStorage.setItem('_token', this.token);
    this.$store.dispatch('SET_USER')
      .finally(() => {
        window.close();
      });
  },
  methods: {
    setUser(response) {
      this.$store.dispatch('setUser', response.data);
    },
  },
};
</script>

<style scoped>

</style>
