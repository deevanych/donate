<template>
  <vs-tooltip>
    <vs-radio :value="value" :val="variation.sum" v-on:input="$emit('input', $event)">
      <div class="proposed-options__item"
           v-bind:style="{ backgroundImage: 'linear-gradient(' + getBackgroundColor + ')',
                         color: getTextColor}">
        <span class="proposed-options__sum">{{ variation.sum }}₽</span>
        <span class="proposed-options__title">{{ variation.title }}</span>
      </div>
    </vs-radio>
    <template #tooltip>
      {{ variation.description }}
    </template>
  </vs-tooltip>
</template>

<script>
export default {
  name: 'DonationVariation',
  props: {
    value: {
      required: true,
    },
    variation: {
      type: Object,
      required: true,
    },
  },
  computed: {
    getBackgroundColor() {
      return JSON.parse(this.variation.appearance).background;
    },
    getTextColor() {
      return JSON.parse(this.variation.appearance).color;
    },
  },
};
</script>

<style scoped lang="scss">
.proposed-options {
  &__item {
    display: flex;
    flex-direction: column;
    border-radius: 10px;
    min-width: 150px;
    padding: 1rem;
    background: #9fcdff;
    cursor: pointer;
    transition: .3s;

    &:hover {
      box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
      transform: scale(1.05);
    }
  }

  &__title {
    white-space: nowrap;
  }

  &__sum {
    font-size: 1.5rem;
    line-height: 1.5rem;
  }
}
</style>
