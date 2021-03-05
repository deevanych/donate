<template>
  <div :class="{'mb-4': ifSlotExist}">
    <h5 class="mb-3 d-flex align-items-center">
      {{ title }}
      <HelpInfo v-if="helpText" :text="helpText" class="ml-2"/>
      <slot name="action"></slot>
    </h5>
    <div class="row input__wrapper">
      <slot></slot>
    </div>
  </div>
</template>

<script>
import HelpInfo from '@/components/@ui/HelpInfoComponent.vue';

export default {
  name: 'InputField',
  components: {
    HelpInfo,
  },
  props: {
    title: {
      type: String,
      required: true,
    },
    helpText: {
      type: String,
    },
  },
  computed: {
    ifSlotExist() {
      return !!this.$slots.default;
    },
  },
};
</script>

<style scoped lang="scss">
  .input__wrapper::v-deep {
    align-items: center;
  }
</style>
