<template>
  <vs-tooltip class="d-flex">
    <i class='bx bx-help-circle'></i>
    <template #tooltip>
      {{ text }}
    </template>
  </vs-tooltip>
</template>

<script>
export default {
  name: 'HelpInfo',
  props: {
    text: {
      type: String,
      required: true,
    },
  },
};
</script>

<style scoped>

</style>
