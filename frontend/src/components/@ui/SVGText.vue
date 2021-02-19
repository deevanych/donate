<template>
  <h1 class="text" :data-text="text.text" :style="style">{{ text.text }}</h1>
</template>

<script>
export default {
  name: 'SVGText',
  props: {
    text: {
      type: Object,
      require: true,
    },
  },
  methods: {
    gradients(type = 'color') {
      return JSON.parse(this.text[type]);
    },
    angleToPoints(type = 'color') {
      const segment = Math.floor((this.gradients(type).angle / Math.PI) * 2) + 2;
      const diagonal = ((1 / 2) * segment + 1 / 4) * Math.PI;
      const op = Math.cos(Math.abs(diagonal - this.gradients(type).angle)) * Math.sqrt(2);
      const x = op * Math.cos(this.gradients(type).angle);
      const y = op * Math.sin(this.gradients(type).angle);

      return {
        x1: x < 0 ? 1 : 0,
        y1: y < 0 ? 1 : 0,
        x2: x >= 0 ? x : x + 1,
        y2: y >= 0 ? y : y + 1,
      };
    },
  },
  computed: {
    style: {
      get() {
        const style = { ...this.text };
        const color = JSON.parse(style.color);
        const gradientColors = [];

        style.padding = `${style.padding}px`;
        style['font-size'] = `${style['font-size']}px`;
        Object.keys(color.stops).forEach((key) => {
          gradientColors.push(`${color.stops[key][0]} ${color.stops[key][1] * 100}%`);
        });

        // text color
        style.background = `linear-gradient(${color.angle}deg, ${gradientColors.join(', ')})`;

        if (this.text.shadowEnabled) {
          style['text-shadow'] = `${style.shadowPosition.x}px ${style.shadowPosition.y}px ${style.shadowBlur}px ${style.shadowColor}`;
        }
        return style;
      },
    },
  },
};
</script>

<style scoped lang="scss">
.text {
  vector-effect: non-scaling-stroke;
  -webkit-background-clip: text !important;
  -webkit-text-fill-color: transparent;

  &::before {
    content: attr(data-text);
    position: absolute;
  }
}
</style>
