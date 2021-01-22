<template>
  <div class="mb-4">
    <h5 class="mb-3">{{ title }}</h5>
    <slot></slot>
  </div>
</template>

<script>
export default {
  name: 'DonationSection',
  props: {
    title: {
      type: String,
      required: true,
    },
  },
};
</script>

<style scoped>

</style>
