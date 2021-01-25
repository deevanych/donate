<template>
  <div class="mb-4">
    <h5 class="mb-3 d-flex align-items-center">
      {{ title }}
      <HelpInfo v-if="helpText" :text="helpText" class="ml-2"/>
    </h5>
    <slot></slot>
  </div>
</template>

<script>
import HelpInfo from '@/components/HelpInfo.vue';

export default {
  name: 'DonationSection',
  components: {
    HelpInfo,
  },
  props: {
    title: {
      type: String,
      required: true,
    },
    helpText: {
      type: String,
    },
  },
};
</script>

<style scoped>

</style>
