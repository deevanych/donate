<template>
  <DonatePageComponent v-if="loaded" :user="user"/>
</template>

<script>
import DonatePageComponent from '@/components/pages/DonatePageComponent.vue';
import { userType } from '@/types/user';
import { getUserProfile } from '@/api/users';

let loading;

export default {
  name: 'DonatePageLayout',
  components: {
    DonatePageComponent,
  },
  data() {
    return {
      user: userType,
      loaded: false,
    };
  },
  methods: {
    updatePreview() {
      this.user = JSON.parse(localStorage.getItem('donatePagePreview'));
    },
  },
  beforeMount() {
    loading = this.$vs.loading();
    if (this.$route.query.type === 'preview') {
      this.updatePreview();
      this.loaded = true;
      loading.close();

      setInterval(() => {
        this.updatePreview();
      }, 100);
      window.addEventListener('beforeunload', () => {
        localStorage.removeItem('donatePagePreview');
      });
    } else {
      getUserProfile(this.$route.params.user).then(({ data }) => {
        this.user = data;
        this.$nextTick(() => {
          this.loaded = true;
        });
        loading.close();
      });
    }
  },
};
</script>
