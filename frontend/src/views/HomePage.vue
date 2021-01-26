<template>
  <div>
    <header class="container mt-5 justify-content-end d-flex">
      <vs-button v-if="!$store.getters.IS_AUTH"
                 @click.prevent="authLogin('http://localhost:8000/auth/twitch')"
                 primary
                 border
                 size="large">
        Войти через <i class='bx bxl-twitch ml-2 social_networks twitch'></i>
      </vs-button>
      <router-link v-else :to="{name: 'dashboard'}">
        <vs-button
          primary
          border
          size="large">
          <vs-avatar history history-gradient circle class="mr-3">
            <img :src="AUTH_USER.avatar_url" alt="">
          </vs-avatar>
          Панель управления
        </vs-button>
      </router-link>
    </header>
    <div class="container d-flex h-100">
      <div class="wrapper">
        <h1 class="title">
          ez
          <br/>
          donate
        </h1>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';

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
  computed: {
    ...mapGetters(['AUTH_USER']),
  },
};
</script>

<style scoped lang="scss">
.container {
  top: 0;
}

.title {
  font-weight: 900;
  text-transform: uppercase;
  font-size: 14rem;
}
</style>
