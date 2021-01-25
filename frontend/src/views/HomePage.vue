<template>
  <div>
    <router-link :to="{name: 'donate', params: {user: 'deevanich'}}">задонатить</router-link>
    <br/>
    <router-link :to="{name: 'widget', params: {user: 'deevanich'}}">чекнуть</router-link>
    <br/>
    <a href="/auth/twitch" @click.prevent="authLogin('/auth/twitch')">Войти через twitch</a>
  </div>
</template>

<script>
let authWindow;
let loading;

export default {
  name: 'Home',
  methods: {
    authLogin(url) {
      loading = this.$vs.loading();
      authWindow = window.open(url, 'authWindow', 'width=300, height=600');
      authWindow.addEventListener('beforeunload', () => {
        loading.close();
        this.$router.push({ name: 'dashboard' });
      });
    },
  },
};
</script>

<style scoped>

</style>
