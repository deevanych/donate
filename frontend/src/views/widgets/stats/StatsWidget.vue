<template>
  <div class="stats__widget p-5" :style="(test ? {background: 'url(https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQaGXoxFEhk28gsLbxBnAv6IHV3EzUHS8kETA&usqp=CAU)'} : '')">
    <div class="stats__widget-wrapper" :class="`text-${align}`">
      <h4 :style="titleStyle" class="widget__title">{{ title.text }}</h4>
      <div v-if="type === 'list'">
        <li v-for="donation in donations"
            :key="donation.id"
            v-html="template(donation)"
        />
      </div>
      <marquee-text v-else-if="type === 'marquee'" :repeat="10" :duration="marqueeSpeed">
        <span v-for="donation in donations"
            :key="donation.id"
              class="mr-4 d-inline-block"
              v-html="template(donation)"
        />
      </marquee-text>
      <div v-else-if="type === 'slider'">
        <VueSlickCarousel class="proposed-options"
                          :arrows="false"
                          :autoplaySpeed="sliderSpeed"
                          :fade="true"
                          :autoplay="true">
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

export default {
  name: 'StatsWidget',
  components: {
    MarqueeText,
    VueSlickCarousel,
  },
  props: {
    test: {
      type: Boolean,
      default: false,
    },
    type: {
      required: true,
      type: String,
    },
    donations: {
      required: true,
      type: Array,
    },
    title: {
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
      '-webkit-text-stroke-width': {
        type: Number,
        default: 0,
      },
      'font-size': {
        type: Number,
        default: 0,
      },
      '-webkit-text-stroke-color': {
        type: String,
        default: 'transparent',
      },
      background: {
        type: String,
        default: 'transparent',
      },
      padding: {
        type: Number,
        default: 0,
      },
    },
    marqueeDuration: {
      type: Number,
      default: 10,
    },
    text_template: {
      type: String,
      default: '{ sender } - { sum }',
    },
    align: {
      type: String,
      default: 'center',
    },
    sliderSpeed: {
      type: Number,
      default: 2000,
    },
  },
  methods: {
    template(donation) {
      const words = [
        'sender',
        'sum',
        'currency',
      ];
      let string = this.text_template;
      words.forEach((word) => {
        string = string.replace(`{ ${word} }`, `<span class="donation__${word}">${donation[word]}</span>`);
      });

      return string;
    },
  },
  computed: {
    marqueeSpeed() {
      return 100 / this.marqueeDuration;
    },
    titleStyle: {
      get() {
        const style = { ...this.title };
        style.padding = `${style.padding}px`;
        style['border-radius'] = `${style['border-radius']}px`;
        style['-webkit-text-stroke-width'] = `${style['-webkit-text-stroke-width']}px`;
        style['font-size'] = `${style['font-size']}px`;
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

<style scoped lang="scss">
.marquee-text-content {

}

.stats__widget {
  display: flex;
  width: 100%;
  height: 100%;

  .stats__widget-wrapper {
    margin: auto 0;
    width: 100%;

    .widget__title {
      display: inline-block;
    }
  }
}
</style>
