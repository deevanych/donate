<template>
  <div>
    <router-link :to="{name: 'donate', params: {user: 'deevanich'}}">задонатить</router-link>
    <br/>
    <router-link :to="{name: 'widget', params: {user: 'deevanich'}}">чекнуть</router-link>
    <br/>
    <a href="/auth/twitch">Войти через twitch</a>
  </div>
</template>

<script>
export default {
  name: 'Home',
};
</script>

<style scoped>

</style>
