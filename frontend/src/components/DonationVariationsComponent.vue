<template>
  <VueSlickCarousel :arrows="false"
                    :focusOnSelect="true"
                    :infinite="false"
                    :slidesToShow="3.3"
                    :swipeToSlide="true"
                    :variableWidth="true"
                    class="proposed-options">
    <DonationVariation v-for='variation in variations'
                       :key="variation.id"
                       :value="value"
                       :variation="variation"
                       v-on:input="$emit('input', $event)"/>
  </VueSlickCarousel>
</template>

<script>
import 'vue-slick-carousel/dist/vue-slick-carousel.css';
import 'vue-slick-carousel/dist/vue-slick-carousel-theme.css';
import VueSlickCarousel from 'vue-slick-carousel';
import DonationVariation from '@/components/DonationVariationComponent.vue';

export default {
  name: 'DonationVariations',
  components: {
    VueSlickCarousel,
    DonationVariation,
  },
  props: {
    value: {
      required: true,
    },
    variations: {
      type: Array,
    },
  },
};
</script>

<style lang="scss" scoped>
.proposed-options::v-deep {
  font-weight: bold;

  .slick-list {
    padding: .5rem 0 1.5rem 1.2rem;

    .slick-track {
      display: flex;

      > .slick-slide {
        margin: 0 .5rem;

        &:first-of-type {
          margin-left: 0;
        }

        &:last-of-type {
          margin-right: 0;
        }
      }
    }
  }

  .vs-radio {
    display: none !important;

    &-content {
      &.active {
        .proposed-options__item {
          box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
          transform: scale(1.05);
        }
      }
    }

    &__label {
      margin: 0;

    }
  }
}
</style>
