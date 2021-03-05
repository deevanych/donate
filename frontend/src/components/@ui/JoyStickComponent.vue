<template>
  <div ref="joy"></div>
</template>

<script>
import nipplejs from 'nipplejs/src/index';

export default {
  name: 'JoyStick',
  props: {
    value: {
      type: Object,
      default: () => ({
        x: 2,
        y: -2,
      }),
    },
  },
  mounted() {
    nipplejs.create({
      zone: this.$refs.joy,
      mode: 'static',
      size: 30,
      position: { left: 0, bottom: 0 },
      color: 'black',
      dynamicPage: true,
      frontPosition: { x: 10, y: 10 },
    })
      .on('move', (e, nipple) => {
        this.$emit('input', nipple.instance.frontPosition);
      });
  },
};
</script>

<style scoped>

</style>
