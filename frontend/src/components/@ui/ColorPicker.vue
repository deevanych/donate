<template>
  <div
    :style="{'background': color}"
    class="color__preview rounded shadow"
    tabindex="0"
    @focus="show = true"
    @focusout="show = false">
    <template v-if="show">
      <VueGpickr v-if="gradient"
              v-model="gradientColor"/>
      <Chrome v-else
              :value="value"
              @input="changeValue"/>
    </template>
  </div>
</template>

<script>
import { VueGpickr, LinearGradient } from 'vue-gpickr';
import { Chrome } from 'vue-color';

export default {
  name: 'ColorPicker',
  components: {
    VueGpickr,
    Chrome,
  },
  props: {
    gradient: {
      type: Boolean,
      default: true,
    },
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
  computed: {
    gradientColor: {
      get() {
        return new LinearGradient(JSON.parse(this.value));
      },
      set(val) {
        this.$emit('input', JSON.stringify(val.toRaw()));
      },
    },
    color() {
      if (this.gradient) {
        return this.gradientColor.toString();
      }

      return this.value;
    },
  },
};
</script>

<style lang="scss" scoped>
.vue-gpickr {
  z-index: 11;
}

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
