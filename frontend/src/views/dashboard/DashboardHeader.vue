<template>
  <header class="dashboard__header my-5 d-flex align-items-center justify-content-between">
    <router-link class="logo" to='/'>
      <h3>EZDONATE</h3>
    </router-link>
    <div class="d-flex align-items-center">
      <span><b>Баланс: </b>
              <animated-number
                :duration="1000"
                :round="1"
                :value="BALANCE"
              />₽</span>
      <vs-avatar badge-color="danger" badge-position="top-right" class="ml-5">
        <i class='bx bx-bell'></i>
        <template #badge>
          28
        </template>
      </vs-avatar>
      <div class="d-flex align-items-center ml-5">
        {{ USER.name }}
        <vs-avatar circle class="ml-3">
          <img :src="USER.avatar_url" alt="">
        </vs-avatar>
      </div>
    </div>
  </header>
</template>

<script>
import { mapGetters } from 'vuex';
import AnimatedNumber from 'animated-number-vue';

export default {
  name: 'DashboardHeader',
  components: {
    AnimatedNumber,
  },
  computed: {
    ...mapGetters(['USER', 'BALANCE']),
  },
  mounted() {
    this.$store.dispatch('GET_BALANCE');
    this.$store.dispatch('GET_USER_PROFILE');
  },
};
</script>

<style lang="scss" scoped>
.dashboard__header {

}
</style>
