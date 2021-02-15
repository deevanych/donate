<template>
  <InputSection title="Заголовок">
    <InputField title="Шрифт">
      <div class="col">
        <div class="row align-items-center">
          <div class="col-auto">
            <ColorPicker v-model="block.color"/>
          </div>
          <div class="col-auto">
            <GoogleFontPicker v-model="block['font-family']"/>
          </div>
          <div class="col-auto">
            <vs-button-group class="justify-content-start">
              <vs-button :active="block['font-style'] === 'italic'" border
                         icon
                         @click="toggleStyle('title', 'font-style', ['italic', 'normal'])">
                <i class='bx bx-italic'></i>
              </vs-button>
              <vs-button :active="block['font-weight'] === 'bold'" border
                         icon
                         @click="toggleStyle('title', 'font-weight', ['normal', 'bold'])">
                <i class='bx bx-bold'></i>
              </vs-button>
              <vs-button :active="block['text-decoration'] === 'underline'" border
                         icon
                         @click="toggleStyle('title', 'text-decoration', ['none', 'underline'])">
                <i class='bx bx-underline'></i>
              </vs-button>
              <vs-button :active="block['text-decoration'] === 'line-through'" border
                         icon
                         @click="toggleStyle('title', 'text-decoration', ['none', 'line-through'])">
                <i class='bx bx-strikethrough'></i>
              </vs-button>
            </vs-button-group>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col">
            <RangeSlider
              v-model="block['font-size']"
              :max="100"
              :min="0"
              tooltip="hover"
            />
          </div>
        </div>
      </div>
    </InputField>
    <InputField title="Обводка">
      <template #action>
        <vs-switch success v-model="block.strokeEnabled" class="ml-3">
          <template #off>
            <i class='bx bx-x' ></i>
          </template>
          <template #on>
            <i class='bx bx-check' ></i>
          </template>
        </vs-switch>
      </template>
      <template v-if="block.strokeEnabled">
        <div class="col">
          <div class="row mb-4 align-items-center">
            <div class="col-auto">
              <ColorPicker v-model="block.stroke"/>
            </div>
            <div class="col">
              <RangeSlider
                v-model="block['stroke-width']"
                :max="5"
                :min="0"
                tooltip="hover"
              />
            </div>
          </div>
        </div>
      </template>
    </InputField>
    <InputField title="Тень">
      <template #action>
        <vs-switch success v-model="block.shadowEnabled" class="ml-3">
          <template #off>
            <i class='bx bx-x' ></i>
          </template>
          <template #on>
            <i class='bx bx-check' ></i>
          </template>
        </vs-switch>
      </template>
      <template v-if="block.shadowEnabled">
        <div class="col">
          <div class="row mb-4 align-items-center">
            <div class="col-auto">
              <ColorPicker v-model="block.shadowColor" :gradient="false"/>
            </div>
            <div class="col-auto">
              <JoyStick v-model="block.shadowPosition"/>
            </div>
            <div class="col">
              <RangeSlider
                v-model="block.shadowBlur"
                :max="10"
                :min="0"
                tooltip="hover"
              />
            </div>
          </div>
        </div>
      </template>
    </InputField>
  </InputSection>
</template>

<script>
import InputField from '@/components/InputField.vue';
import InputSection from '@/components/InputSection.vue';
import ColorPicker from '@/components/@ui/ColorPicker.vue';
import GoogleFontPicker from '@/components/@ui/GoogleFontPicker.vue';
import RangeSlider from 'vue-range-component-fixed';
import JoyStick from '@/components/@ui/JoyStick.vue';

export default {
  name: 'AppearanceBlock',
  props: {
    block: {
      type: Object,
      require: true,
    },
    stroke: {
      type: Boolean,
      default: false,
    },
  },
  components: {
    ColorPicker,
    InputField,
    InputSection,
    GoogleFontPicker,
    JoyStick,
    RangeSlider,
  },
  methods: {
    toggleStyle(property, style, values) {
      this.block[style] = (this.block[style] === values[0] ? values[1] : values[0]);
    },
  },
};
</script>

<style scoped>

</style>
