<template>
  <span class="text-muted small">
    {{ text }}
  </span>
</template>

<script>
export default {
  name: 'InfoDescription',
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
