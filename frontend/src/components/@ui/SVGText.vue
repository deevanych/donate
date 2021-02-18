<template>
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 100">
    <defs>
      <linearGradient v-if="text.strokeEnabled"
                      id="stroke"
                      :x1="angleToPoints('stroke').x1"
                      :x2="angleToPoints('stroke').x2"
                      :y1="angleToPoints('stroke').y1"
                      :y2="angleToPoints('stroke').y2"
      >
        <stop v-for="(color, n) in gradients('stroke').stops"
              :key="n"
              :stop-color="color[0]"
              :offset="color[1]"/>
      </linearGradient>
      <linearGradient id="fill"
                      :x1="angleToPoints.x1"
                      :x2="angleToPoints.x2"
                      :y1="angleToPoints.y1"
                      :y2="angleToPoints.y2"
      >
        <stop v-for="(color, n) in gradients('color').stops"
              :key="n"
              :stop-color="color[0]"
              :offset="color[1]"/>
      </linearGradient>
      <filter x="0" y="0" width="1" height="1" id="background">
        <feFlood flood-color="yellow" result="bg"/>
        <feMerge>
          <feMergeNode in="bg"/>
          <feMergeNode in="SourceGraphic"/>
        </feMerge>
      </filter>
<!--      todo-->
<!--      <filter id="shadow" x="0" y="0" width="200%" height="200%">-->
<!--        <feOffset result="offOut" in="SourceGraphic" dx="20" dy="20"/>-->
<!--        <feColorMatrix result="matrixOut" in="offOut" type="matrix"-->
<!--                       values="0.2 0 0 0 0 0 0.2 0 0 0 0 0 0.2 0 0 0 0 0 1 0"/>-->
<!--        <feGaussianBlur result="blurOut" in="matrixOut" stdDeviation="10"/>-->
<!--        <feBlend in="SourceGraphic" in2="blurOut" mode="normal"/>-->
<!--      </filter>-->
    </defs>
    <g>
      <text class="text"
            :style="style"
            :y="text['font-size'] * 0.9"
            fill="url(#fill)"
            stroke="url(#stroke)"
      >
        {{ text.text }}
      </text>
    </g>

  </svg>
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
        style.padding = `${style.padding}px`;
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

}
</style>
