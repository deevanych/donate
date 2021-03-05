<template>
  <div :id="title" class="mb-5">
    <div class="row">
      <h3 class="col mb-4"><a :href="`#${title}`">#</a> {{ title }}</h3>
      <slot class="col-auto" name="action"></slot>
    </div>
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
