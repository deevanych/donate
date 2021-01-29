<template>
  <input type="range" :value="value" class="custom-range" :min="min" :max="max" :step="step" :input="test">
</template>

<script>
export default {
  name: 'RangeSlider',
  props: {
    min: {
      type: Number,
      default: 1,
    },
    max: {
      type: Number,
      default: 100,
    },
    step: {
      type: Number,
      default: 1,
    },
    value: {
      required: true,
    },
  },
  methods: {
    test() {
      console.log(4);
    },
  },
};
</script>

<style scoped>

</style>
