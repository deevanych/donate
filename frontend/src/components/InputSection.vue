<template>
  <div class="mb-5" :id="title">
    <h3 class="mb-4"><a :href="`#${title}`">#</a> {{ title }}</h3>
    <div class="ml-4">
      <slot/>
    </div>
  </div>
</template>

<script>
export default {
  name: 'InputSection',
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
