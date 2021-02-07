<template>
  <div class="mb-5" :id="title">
    <div class="row">
    <h3 class="col mb-4"><a :href="`#${title}`">#</a> {{ title }}</h3>
      <slot name="action" class="col-auto"></slot>
    </div>
      <slot/>
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
