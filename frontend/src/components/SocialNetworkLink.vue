<template>
  <vs-tooltip>
    <a :href="link" target="_blank" class="d-flex ml-2 social_networks" :class="type">
      <i class='bx' :class="`bxl-${type}`"></i>
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
