<template>
  <vs-radio :value="value" :val="sum" v-on:input="$emit('input', $event)">
    <div class="proposed-options__item">
      <span class="proposed-options__sum">{{ sum }}₽</span>
      <span class="proposed-options__title">{{ description }}</span>
    </div>
  </vs-radio>
</template>

<script>
export default {
  name: 'DonationVariation',
  props: {
    value: {
      required: true,
    },
    sum: {
      type: Number,
      required: true,
    },
    description: {
      type: String,
      required: true,
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
