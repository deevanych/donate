<template>
  <div>
    <header class="container mt-5 justify-content-end d-flex">
      <vs-button v-if="!$store.getters.IS_AUTH"
                 @click.prevent="authLogin('/auth/twitch')"
                 primary
                 border
                 size="large">
        Войти через <i class='bx bxl-twitch ml-2 social_networks twitch'></i>
      </vs-button>
      <router-link v-else :to="{name: 'dashboard.index'}">
        <vs-button
          primary
          border
          size="large">
          <vs-avatar history history-gradient circle class="mr-3">
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
import Vue from 'vue';

let authWindow;
let loading;

export default {
  name: 'Home',
  methods: {
    authLogin(url) {
      loading = this.$vs.loading();
      authWindow = window.open(url, 'authWindow', 'width=300, height=600');
      authWindow.addEventListener('beforeunload', () => {
        // todo
        if (process.env.NODE_ENV !== 'production') {
          localStorage.setItem('_token', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMDFjZTEzMjc3NjMwODRjNzljNzM1YzMzYjA3MjI3ZDVlZDA1Zjg2MTE1NWI0NjVjOGMyOWQ3MjZkM2Y0ZjNlYjQxZTcyNTliZTQwOWYxMjgiLCJpYXQiOiIxNjEyMTQzNjQ3LjMxNTU2NCIsIm5iZiI6IjE2MTIxNDM2NDcuMzE1NTcwIiwiZXhwIjoiMTY0MzY3OTY0Ny4yNTExMDciLCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.LT9vq-Fhd31cE_sQJ91XTfCJIIFW1irjIbV3hbvfvcuFUMMJ0JmbrfQgVnqlL-iSaIqVwClCLkbVecy9XKwGpe_OwyJL48RR46Om-26ltZoxbMoX9c-92ToZpNob6Vjh-KAbQdnam-f26mQRuHypjg7YL4VTxE1tdpoWqzR2iZL09raFDMl8FiJTXBnCm8Pg6htNRQVB-UlSklFOsy3fDFAmHV7sJD-Bmg-IqDtdaf2P06RM5iB7ou72-bzeZfuoymOYyG84YFOoFTmsUJywrkdtRC-cmfpQptmdWpQOMFClAjR1pNsweaG_-Xn0m8A66kjrzUth_aZ09-426861E4KYdPCgd7XiM_dFrZqTfs0-HAGRfTZX_O2EGv4XebDhLYUMYCKhgoMFAhiAAGbwsf1Mr0JtqTS_vm8Wcq30xsokCfGXhN4Ke8qrNmfoFTF0O8Q1wG-kvuLOpK44Dvd_IyQvt5P4fhvqtQAugkpkVxeIT-qmt-kqZBMCfQg3JCbJ3UHuCZ0I8_po-MYiiVnU0ru8_mxxdMloZUJ93Uc5qPD8wVr7cwJye14Tp9_AfHCevjRsS9bW2RDaVQcH-Q6xaWWmIuwps3mla88OiINLOE0khDc7PzTOXI7NNoxWdwt5QO6IZu7WDwO42yIoQgmmvUkM7e3eNaCbiyE3wNKqjcI');
        }

        Vue.prototype.$http.defaults.headers.common.Authorization = `Bearer ${localStorage.getItem('_token') || null}`;

        this.$store.dispatch('GET_USER')
          .then(() => {
            this.$router.push({ name: 'dashboard.index' });
          })
          .catch(() => {
            Vue.prototype.$vs.notification({
              position: 'top-right',
              border: 'danger',
              title: 'Произошла ошибка',
              text: 'При авторизации произошла ошибка',
            });
          })
          .finally(() => {
            loading.close();
          });
      });
    },
  },
  computed: {
    ...mapGetters(['USER']),
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
