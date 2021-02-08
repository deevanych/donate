<template>
  <div>
    <VueHeadFul
      :title="pageTitle"
    />
    <header class="container mt-5 justify-content-end d-flex">
      <a v-if="!$store.getters.IS_AUTH" href="/auth/twitch">
        <vs-button
          border
          primary
          size="large">
          Войти через <i class='bx bxl-twitch ml-2 social_networks twitch'></i>
        </vs-button>
      </a>
      <router-link v-else :to="{name: 'dashboard.index'}">
        <vs-button
          border
          primary
          size="large">
          <vs-avatar circle class="mr-3" history history-gradient>
            <img :src="USER.avatar_url" alt="">
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
import store from '@/store';

export default {
  name: 'Home',
  computed: {
    ...mapGetters(['USER']),
  },
  data() {
    return {
      pageTitle: 'ezdonate - система для приема донатов',
    };
  },
  mounted() {
    return !store.getters.IS_AUTH || store.dispatch('GET_USER_PROFILE');
  },
};
</script>

<style lang="scss" scoped>
.container {
  top: 0;
}

.title {
  font-weight: 900;
  text-transform: uppercase;
  font-size: 14rem;
}
</style>
