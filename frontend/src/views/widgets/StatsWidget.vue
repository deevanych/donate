<template>
  <div
    :style="(test ? {background: 'url(https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQaGXoxFEhk28gsLbxBnAv6IHV3EzUHS8kETA&usqp=CAU)'} : '')"
    class="stats__widget p-5">
    <div :class="`text-${widget.align}`" class="stats__widget-wrapper">
      <drr
        :x="widget.title.x"
        :y="widget.title.y"
        :w="widget.title.w"
        :h="widget.title.h"
        :angle="widget.title.angle"
        :aspectRatio="true"
        @change="itemChange"
      >
        <SVGText :text="widget.title"/>
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
        x: {
          type: Number,
          required: false,
          default: 0,
        },
        y: {
          type: Number,
          required: false,
          default: 0,
        },
        w: {
          type: Number,
          required: false,
          default: 0,
        },
        h: {
          type: Number,
          required: false,
          default: 0,
        },
        angle: {
          type: Number,
          required: false,
          default: 0,
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
        '-webkit-text-stroke-width': {
          type: Number,
          default: 0,
        },
        '-webkit-text-stroke-color': {
          type: String,
          default: 'red',
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
    itemChange(re) {
      console.log(re);
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
        style.padding = `${style.padding}px`;
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

.ddr::v-deep {
  width: auto !important;
  height: auto !important;
}
.marquee-text-content {

}

.widget__background {
  -webkit-background-clip: text !important;
}

.stats__widget {
  display: flex;
  width: 100%;
  height: 100%;

  .stats__widget-wrapper {
    margin: auto 0;
    width: 100%;
    position: relative;

    .widget__title {
      display: inline-block;
    }
  }
}

</style>
