<template>
  <InputSection title="Заголовок">
    <InputField title="Шрифт">
      <div class="col">
        <div class="row align-items-center">
          <div class="col-auto">
            <ColorPicker v-model="block.color"/>
          </div>
          <div class="col-auto">
            <GoogleFontPicker v-model="block.fontFamily"/>
          </div>
          <div class="col-auto">
            <vs-button-group class="justify-content-start">
              <vs-button :active="block.fontStyle === 'italic'" border
                         icon
                         @click="toggleStyle('title', 'fontStyle', ['italic', 'normal'])">
                <i class='bx bx-italic'></i>
              </vs-button>
              <vs-button :active="block.fontWeight === 'bold'" border
                         icon
                         @click="toggleStyle('title', 'fontWeight', ['normal', 'bold'])">
                <i class='bx bx-bold'></i>
              </vs-button>
              <vs-button :active="block.textDecoration === 'underline'" border
                         icon
                         @click="toggleStyle('title', 'textDecoration', ['none', 'underline'])">
                <i class='bx bx-underline'></i>
              </vs-button>
              <vs-button :active="block.textDecoration === 'line-through'" border
                         icon
                         @click="toggleStyle('title', 'textDecoration', ['none', 'line-through'])">
                <i class='bx bx-strikethrough'></i>
              </vs-button>
            </vs-button-group>
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
              <ColorPicker v-model="block.strokeColor"/>
            </div>
            <div class="col">
              <RangeSlider
                v-model="block.strokeWidth"
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
    <InputField title="Цвет и отступ фона">
      <template #action>
        <vs-switch success v-model="block.block.backgroundColorEnabled" class="ml-3">
          <template #off>
            <i class='bx bx-x' ></i>
          </template>
          <template #on>
            <i class='bx bx-check' ></i>
          </template>
        </vs-switch>
      </template>
      <template v-if="block.block.backgroundColorEnabled">
        <div class="col">
          <div class="row mb-4 align-items-center">
            <div class="col-auto">
              <ColorPicker v-model="block.block.backgroundColor"/>
            </div>
            <div class="col">
              <RangeSlider
                v-model="block.block.padding"
                :max="50"
                :min="0"
                tooltip="hover"
              />
            </div>
          </div>
        </div>
      </template>
    </InputField>
    <InputField title="Обводка и закругление фона">
      <template #action>
        <vs-switch success v-model="block.block.backgroundStrokeEnabled" class="ml-3">
          <template #off>
            <i class='bx bx-x' ></i>
          </template>
          <template #on>
            <i class='bx bx-check' ></i>
          </template>
        </vs-switch>
      </template>
      <template v-if="block.block.backgroundStrokeEnabled">
        <div class="col">
          <div class="row mb-4 align-items-center">
            <div class="col-auto">
              <ColorPicker v-model="block.block.backgroundStrokeColor" :gradient="false"/>
            </div>
            <div class="col">
              <RangeSlider
                v-model="block.block.backgroundStrokeWidth"
                :max="10"
                :min="0"
                tooltip="hover"
              />
            </div>
            <div class="col">
              <RangeSlider
                v-model="block.block.backgroundStrokeRadius"
                :max="100"
                :min="0"
                tooltip="hover"
              />
            </div>
          </div>
        </div>
      </template>
    </InputField>
    <InputField title="Тень фона">
      <template #action>
        <vs-switch success v-model="block.block.backgroundShadowEnabled" class="ml-3">
          <template #off>
            <i class='bx bx-x' ></i>
          </template>
          <template #on>
            <i class='bx bx-check' ></i>
          </template>
        </vs-switch>
      </template>
      <template v-if="block.block.backgroundShadowEnabled">
        <div class="col">
          <div class="row mb-4 align-items-center">
            <div class="col-auto">
              <ColorPicker v-model="block.block.backgroundShadowColor" :gradient="false"/>
            </div>
            <div class="col-auto">
              <JoyStick v-model="block.block.backgroundShadowPosition"/>
            </div>
            <div class="col">
              <RangeSlider
                v-model="block.block.backgroundShadowBlur"
                :max="20"
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
import InputField from '@/components/@ui/InputFieldComponent.vue';
import InputSection from '@/components/@ui/InputSectionComponent.vue';
import ColorPicker from '@/components/@ui/ColorPickerComponent.vue';
import GoogleFontPicker from '@/components/@ui/GoogleFontPickerComponent.vue';
import RangeSlider from 'vue-range-component-fixed';
import JoyStick from '@/components/@ui/JoyStickComponent.vue';

export default {
  name: 'AppearanceBlock',
  props: {
    block: {
      type: Object,
      require: true,
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
