<template>
  <div
    :style="{'background-color': value}"
    class="color__preview rounded shadow"
    tabindex="0"
    @focus="show = true"
    @focusout="show = false">
    <Chrome v-if="show"
            :value="value"
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
<style lang="scss" scoped>
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
