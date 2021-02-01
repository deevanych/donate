<template>
  <div class="range__slider" :style="{background: backgroundColor, 'width': width}" ref="slider" @mousedown="startMove">
    <div class="range__value" :style="{'width': rangeValue, background: sliderFillColor}"/>
    <div class="range__handler shadow-sm" :style="{'left': rangeValue, background: handlerColor}"/>
  </div>
</template>

<script>
export default {
  name: 'RangeSlider',
  props: {
    width: {
      type: String,
      default: '100',
    },
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
    backgroundColor: {
      type: String,
      default: 'rgba(var(--vs-gray-2), 1)',
    },
    handlerColor: {
      type: String,
      default: 'rgba(var(--vs-primary), 1)',
    },
    sliderFillColor: {
      type: String,
      default: 'rgba(var(--vs-primary), .2)',
    },
  },
  data() {
    return {
      sliderWidth: 0,
    };
  },
  methods: {
    changeValue(e) {
      this.$emit('input', this.getComputedValue(e.pageX));
    },
    changeValueTouch(e) {
      this.$emit('input', this.getComputedValue(e.touches[0].pageX));
    },
    startMove(e) {
      this.changeValue(e);
      document.body.addEventListener('mousemove', this.changeValue);
      document.body.addEventListener('mouseup', this.stopMove);
      document.body.addEventListener('touchmove', this.changeValueTouch);
      document.body.addEventListener('touchend', this.stopMove);
    },
    stopMove() {
      document.body.removeEventListener('mousemove', this.changeValue);
      document.body.removeEventListener('mouseup', this.stopMove);
    },
    getComputedValue(pageX) {
      let computedValue = Math.floor((pageX - this.$refs.slider.getBoundingClientRect().left) / this.pixelsPerStep);
      computedValue = (this.max <= computedValue) ? this.max : computedValue;
      computedValue = (this.min >= computedValue) ? this.min : computedValue;
      return computedValue;
    },
  },
  mounted() {
    this.sliderWidth = this.$refs.slider.clientWidth;
  },
  computed: {
    pixelsPerStep() {
      return this.sliderWidth / this.max;
    },
    rangeValue() {
      return `${this.pixelsPerStep * this.value}px`;
    },
  },
};
</script>

<style scoped lang="scss">
  .range__slider {
    width: 100%;
    height: 10px;
    position: relative;
    cursor: pointer;
    border-radius: 25px;

    &.range__slider--animated {
      transition: .3s;
    }

    .range__value {
      height: 100%;
      position: absolute;
      left: 0;
      top: 0;
      border-radius: 5px;
    }

    .range__handler {
      width: 1rem;
      height: 1rem;
      border-radius: 100%;
      position: absolute;
      margin-top: -3px;
      margin-left: -5px;
    }
  }
</style>
