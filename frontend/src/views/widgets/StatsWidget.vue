<template>
  <div
    :style="(test ? {background: 'url(https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQaGXoxFEhk28gsLbxBnAv6IHV3EzUHS8kETA&usqp=CAU)'} : '')"
    class="stats__widget"
    :class="{'p-5': test}">
    <div :class="`text-${widget.align}`" class="stats__widget-wrapper">
      <drr
        :x="widget.title.block.coords.x"
        :y="widget.title.block.coords.y"
        :w="widget.title.block.coords.w"
        :h="widget.title.block.coords.h"
        :angle="widget.title.block.coords.angle"
        :aspectRatio="true"
        :selectable="test"
        @change="itemChange('title', $event)"
        @resize="sizeChange('title', $event)"
        class="ddr__block">
        <div class="drr__wrapper" :style="getStyle('title')">
          <SVGText ref="block" :text="widget.title"/>
        </div>
      </drr>
      <div v-if="widget.widget_view_type === 'list'">
        <li v-for="donation in donations"
            :key="donation.id"
            v-html="template(donation)"
        />
      </div>
      <marquee-text v-else-if="widget.widget_view_type === 'marquee'" :duration="marqueeSpeed" :repeat="10">
        <span v-for="donation in donations"
              :key="donation.id"
              class="mr-4 d-inline-block"
              v-html="template(donation)"
        />
      </marquee-text>
      <div v-else-if="widget.widget_view_type === 'slider'">
        <VueSlickCarousel :arrows="false"
                          :autoplay="true"
                          :autoplaySpeed="widget.slider_speed"
                          :fade="true"
                          class="proposed-options">
          <span v-for="donation in donations"
                :key="donation.id"
                v-html="template(donation)"
          />
        </VueSlickCarousel>
      </div>
    </div>
  </div>
</template>

<script>
import 'vue-slick-carousel/dist/vue-slick-carousel.css';
import 'vue-slick-carousel/dist/vue-slick-carousel-theme.css';
import MarqueeText from 'vue-marquee-text-component';
import VueSlickCarousel from 'vue-slick-carousel';
import { LinearGradient } from 'vue-gpickr';
import SVGText from '@/components/@ui/SVGText.vue';

export default {
  name: 'StatsWidget',
  components: {
    MarqueeText,
    VueSlickCarousel,
    SVGText,
  },
  props: {
    test: {
      type: Boolean,
      default: false,
    },
    donations: {
      required: true,
      type: Array,
    },
    widget: {
      title: {
        block: {
          x: {
            type: Number,
            default: 0,
          },
          y: {
            type: Number,
            default: 0,
          },
          w: {
            type: Number,
            default: 0,
          },
          h: {
            type: Number,
            default: 0,
          },
          angle: {
            type: Number,
            default: 0,
          },
          zoom: {
            type: Number,
            default: 1,
          },
        },
        text: {
          type: String,
          required: false,
        },
        color: {
          type: String,
          default: '#000000',
        },
        'font-family': {
          type: String,
          default: 'initial',
        },
        'border-radius': {
          type: Number,
          default: 0,
        },
        'font-size': {
          type: Number,
          default: 0,
        },
        padding: {
          type: Number,
          default: 0,
        },
      },
      marquee_duration: {
        type: Number,
        default: 10,
      },
      text_template: {
        type: String,
        default: '{ donation_sender } - { sum }',
      },
      align: {
        type: String,
        default: 'center',
      },
      slider_speed: {
        type: Number,
        default: 2000,
      },
      widget_view_type: {
        type: String,
        default: 'marquee',
      },
    },
  },
  methods: {
    getStyle(type = 'title') {
      const style = { ...this.widget[type].block };

      if (style.backgroundColorEnabled) {
        const color = JSON.parse(style.backgroundColor);
        const gradientColors = [];

        style.padding = `${style.padding}px`;

        Object.keys(color.stops).forEach((key) => {
          gradientColors.push(`${color.stops[key][0]} ${color.stops[key][1] * 100}%`);
        });

        // text color
        style.background = `linear-gradient(${color.angle}deg, ${gradientColors.join(', ')})`;
      }

      if (style.backgroundShadowEnabled) {
        style['box-shadow'] = `${style.backgroundShadowPosition.x}px ${style.backgroundShadowPosition.y}px ${style.backgroundShadowBlur}px ${style.backgroundShadowColor}`;
      }

      if (style.backgroundStrokeEnabled) {
        style.border = `${style.backgroundStrokeWidth}px solid ${style.backgroundStrokeColor}`;
        style.borderRadius = `${style.backgroundStrokeRadius}px`;
      }

      return style;
    },
    itemChange(type, coords) {
      Object.assign(this.widget[type].block.coords, coords);
    },
    sizeChange(type, coords) {
      const startWidth = this.$refs.block.$el.clientWidth;
      this.$emit('changeZoom', coords.w / startWidth);
    },
    template(donation) {
      const words = [
        'donation_sender',
        'sum',
        'currency',
        'id',
      ];
      let string = this.widget.text_template;
      words.forEach((word) => {
        string = string.replace(`{ ${word} }`, `<span class="donation__${word}">${donation[word]}</span>`);
      });

      return string;
    },
  },
  computed: {
    marqueeSpeed() {
      return 100 / this.widget.marquee_duration;
    },
    titleStyle: {
      get() {
        const style = { ...this.widget.title };
        style['border-radius'] = `${style['border-radius']}px`;
        style['-webkit-text-stroke-width'] = `${style['-webkit-text-stroke-width']}px`;
        style['font-size'] = `${style['font-size']}px`;
        style['-webkit-text-fill-color'] = 'transparent';
        style.color = new LinearGradient(JSON.parse(style.color)).toString();
        return style;
      },
    },
  },
  watch: {
    title: {
      handler() {
        return this.titleStyle.get;
      },
      deep: true,
    },
  },
};
</script>

<style lang="scss" scoped>

.marquee-text-content {

}

.widget__background {
  -webkit-background-clip: text !important;
}

.stats__widget {
  display: flex;
  width: 100%;
  height: 100%;
  overflow: hidden;
  align-items: center;

  .stats__widget-wrapper::v-deep {
    margin: auto 0;
    width: 100%;
    position: relative;

    .drr__wrapper {

      &:before {
        content: '';
        background: red;
        width: 100%;
        height: 100%;
        left: 0;
        top: 0;
      }
    }

    .ddr__block {
      width: auto !important;
      height: auto !important;

      .drr__stroke {
        position: absolute;
      }
    }

    .widget__title {
      display: inline-block;
    }
  }
}

</style>
