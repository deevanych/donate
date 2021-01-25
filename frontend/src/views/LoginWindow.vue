<template>
  <div>
    Авторизация успешна
    {{ token }}
  </div>
</template>

<script>
import user from '@/api/user';

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
    user.get('', this.setUser);
  },
  methods: {
    setUser(response) {
      this.$store.dispatch('setUser', response.data);
      window.close();
    },
  },
};
</script>

<style scoped>

</style>
