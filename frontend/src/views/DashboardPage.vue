<template>
  <div>
    asdsad
  </div>
</template>

<script>
import user from '@/api/user';

export default {
  name: 'DashboardPage',
  mounted() {
    console.log(this.$route.query.token);
    user.get('', this.userInfo, this.userInfo);
  },
  methods: {
    userInfo() {
      console.log(this.$cookie.get('_token'));
    },
  },
};
</script>

<style scoped>

</style>
