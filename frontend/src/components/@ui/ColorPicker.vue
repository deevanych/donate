<template>
  <div
    class="color__preview rounded shadow"
    @focus="show = true"
    @focusout="show = false"
    tabindex="0"
    :style="{'background-color': value}">
    <Chrome :value="value"
            v-if="show"
            @input="changeValue"/>
  </div>
</template>

<script>
import { Chrome } from 'vue-color';

export default {
  name: 'ColorPicker',
  components: {
    Chrome,
  },
  props: {
    value: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      show: false,
    };
  },
  methods: {
    changeValue(colors) {
      this.$emit('input', colors.hex8);
    },
  },
};
</script>

<!--    @focus="toggleColorPicker('main_color', true)"-->
<!--    @focusout="toggleColorPicker('main_color', false)"-->
<style scoped lang="scss">
.color__preview {
  width: 30px;
  height: 30px;
  cursor: pointer;
  position: relative;

  .vc-chrome::v-deep {
    top: 3rem;
    position: absolute;
    z-index: 6;
    border-radius: 10px;
    overflow: hidden;

    .vc-chrome-saturation-wrap {
      padding-bottom: 100%;
    }

    .vc-chrome-fields-wrap {
      display: none;
    }
  }
}
</style>
