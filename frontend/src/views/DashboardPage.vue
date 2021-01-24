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
    user.get('', this.userInfo, this.userInfo);
  },
  methods: {
    userInfo(userInfo) {
      console.log(userInfo);
    },
  },
};
</script>

<style scoped>

</style>
