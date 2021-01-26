<template>
  <div class="mb-5 d-flex justify-content-between align-items-start">
    <a href="#" @click="$router.go(-1)" class="page__title d-flex align-items-start">
      <i class='bx bx-arrow-back mr-3 mt-1'></i>
      <div>
        <h1 class="mb-0 text-dark">{{ title }}</h1>
        <InfoDescription v-if="description" :text="description"/>
      </div>
    </a>
    <slot/>
  </div>
</template>

<script>
import InfoDescription from '@/components/InfoDescription.vue';

export default {
  name: 'DashboardPageTitle',
  components: {
    InfoDescription,
  },
  props: {
    title: {
      type: String,
      required: true,
    },
    description: {
      type: String,
      required: false,
    },
  },
};
</script>

<style scoped lang="scss">
.page__title {
  text-decoration: none;

  h1, i {
    font-size: 2.5rem;
    font-weight: 900;
  }
}
</style>
