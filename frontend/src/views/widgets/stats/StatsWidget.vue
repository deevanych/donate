<template>
  <div class="stats__widget p-5" :style="(test ? {background: 'url(https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQaGXoxFEhk28gsLbxBnAv6IHV3EzUHS8kETA&usqp=CAU)'} : '')">
    <div class="stats__widget-wrapper">
      <div v-if="type === 'list'" :class="`text-${align}`">
        <h4>{{ title }}</h4>
        <li v-for="donation in donations"
            :key="donation.id"
            v-html="template(donation)"
        />
      </div>
      <template v-else-if="type === 'marquee'">
        <h4>{{ title }}</h4>
      <marquee-text :repeat="10" :duration="marqueeSpeed">
        <span v-for="donation in donations"
            :key="donation.id"
              class="mr-4 d-inline-block"
              v-html="template(donation)"
        />
      </marquee-text>
      </template>
      <div v-else-if="type === 'slider'" :class="`text-${align}`">
        <h4>{{ title }}</h4>
        <VueSlickCarousel class="proposed-options"
                          :arrows="false"
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
      required: false,
      type: String,
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
  }
}
</style>
