<template>
  <div class="text__block" :style="{zoom: style.block.coords.zoom}">
    <div class="text__wrapper">
      <div v-if="style.shadowEnabled" class="text__item text__shadow" :style="style">{{ text.text }}</div>
      <div v-if="style.strokeEnabled" class="text__item text__stroke" :style="{...style, ...getStroke}">{{
          text.text
        }}
      </div>
      <div class="text__item text__helper" :style="style" v-html="formattedText"/>
    </div>
  </div>
</template>

<script>
const { parse } = require('@devsnowflake/text-emoji-parser');

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
    formattedText() {
      let str = this.text.text;
      const foundedEmoji = parse(str);

      foundedEmoji.forEach((elem) => {
        console.log(new RegExp(`(${elem.text})`, 'gu'));
        str = str.replace(new RegExp(`(${elem.text})`, 'gu'), '<span class=\'emoji__wrapper\'>$1</span>');
      });

      return str;
    },
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
    getStroke() {
      const style = {};
      const color = JSON.parse(this.text.strokeColor);
      const gradientColors = [];
      Object.keys(color.stops).forEach((key) => {
        gradientColors.push(`${color.stops[key][0]} ${color.stops[key][1] * 100}%`);
      });

      style.background = `linear-gradient(${color.angle}deg, ${gradientColors.join(', ')})`;
      style['-webkit-text-stroke-width'] = `${this.text.strokeWidth}px`;

      return style;
    },
  },
};
</script>

<style scoped lang="scss">
.text {

  &__wrapper {
    position: relative;

    .text {
      &__item {
        -webkit-background-clip: text !important;
        -webkit-text-fill-color: transparent;
      }

      &__helper::v-deep {

        position: relative;
        z-index: 2;
        text-shadow: none !important;

        .emoji__wrapper {
          -webkit-text-fill-color: initial;
        }
      }

      &__shadow, &__stroke {
        position: absolute;
        top: 0;
        left: 0;
        color: #fff;
        background: none;
      }

      &__stroke {
        z-index: 1;
        -webkit-text-stroke-color: transparent;
        -webkit-background-clip: text !important;
        text-shadow: none !important;
      }
    }
  }
}
</style>
