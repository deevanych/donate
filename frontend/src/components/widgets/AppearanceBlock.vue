<template>
  <InputSection title="Настройки блока">
    <InputField title="Шрифт">
      <GoogleFontPicker v-model="block['font-family']"/>
    </InputField>
    <InputField title="Цвет текста">
      <vue-gpickr v-model="gradient" />
    </InputField>
  </InputSection>
</template>

<script>
import InputField from '@/components/InputField.vue';
import InputSection from '@/components/InputSection.vue';
// import ColorPicker from '@/components/@ui/ColorPicker.vue';
import GoogleFontPicker from '@/components/@ui/GoogleFontPicker.vue';
// import { ColorPicker } from 'vue-color-gradient-picker';
import { VueGpickr, LinearGradient } from 'vue-gpickr';

export default {
  name: 'AppearanceBlock',
  props: {
    block: {
      type: Object,
      require: true,
    },
  },
  components: {
    InputField,
    InputSection,
    // ColorPicker,
    GoogleFontPicker,
    VueGpickr,
  },
  computed: {
    gradient: {
      get() {
        return new LinearGradient(this.block.color);
      },
      set(val) {
        this.block.color = val.toString();
      },
    },
  },
};
</script>

<style scoped>

</style>
