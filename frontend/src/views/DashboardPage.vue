<template>
  <div>
    {{ ko }}
  </div>
</template>

<script>
import user from '@/api/user';

export default {
  name: 'DashboardPage',
  data() {
    return {
      ko: null,
    };
  },
  mounted() {
    this.ko = localStorage.getItem('_token');
    user.get('', this.userInfo, this.userInfo);
  },
  methods: {
    userInfo() {

    },
  },
};
</script>

<style scoped>

</style>
