<template>
  <vs-tooltip>
    <a :class="type" :href="link" class="d-flex ml-2 social_networks" target="_blank">
      <i :class="`bxl-${type}`" class='bx'></i>
    </a>
    <template #tooltip>
      {{ link }}
    </template>
  </vs-tooltip>
</template>

<script>
export default {
  name: 'SocialNetworkLink',
  props: {
    type: {
      type: String,
      required: true,
    },
    link: {
      type: String,
      required: true,
    },
  },
};
</script>

<style scoped>

</style>
