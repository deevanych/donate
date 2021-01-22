<template>
  <VueSlickCarousel class="proposed-options"
                    :arrows="false"
                    :variableWidth="true"
                    :infinite="false"
                    :focusOnSelect="true"
                    :slidesToShow="3.3"
                    :swipeToSlide="true">
    <DonationVariation v-for='variation in variations'
                       :key="variation.id"
                       :variation="variation"
                       :value="value"
                       v-on:input="$emit('input', $event)"/>
  </VueSlickCarousel>
</template>

<script>
import VueSlickCarousel from 'vue-slick-carousel';
import DonationVariation from '@/components/DonationVariation.vue';

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

<style scoped lang="scss">
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
