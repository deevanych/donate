<template>
  <div>
    <DashboardPageTitle
      title="Страница доната"
      description="Настрой страницу под себя">
      <vs-button @click="donatePagePreview"
                 size="large"
                 border
                 class="flex-shrink-0">
        Превью
        <HelpInfo
          text="Откроется страница донатов в новом окне, которая будет отображать ваши изменения в реальном времени. Меняйте настройки тут и сразу же смотрите результат там."
          class="ml-2"/>
      </vs-button>
    </DashboardPageTitle>
    <iframe v-if="showPreview" src="/preview/donate" frameborder="0"></iframe>
    <InputSection title="Настройки фона">
      <InputField title="Фоновое изображение">
        <vs-input v-model="AUTH_USER.settings.background_uri" autocomplete="off">
          <template #icon>
            <i class='bx bx-user'></i>
          </template>
        </vs-input>
      </InputField>
      <InputField title="Фоновый цвет">
        <div
          class="color__preview rounded shadow"
          @focus="toggleColorPicker('background_color', true)"
          @focusout="toggleColorPicker('background_color', false)"
          tabindex="0"
          :style="{'background-color': AUTH_USER.settings.background_color}"
        >
          <Chrome
            v-model="AUTH_USER.settings.background_color"
            v-if="colorPickers.background_color"
            @input="AUTH_USER.settings.background_color = $event.hex8"
          />
        </div>
      </InputField>
      <InputField title="Размытие изображения">
        <RangeSlider v-model="AUTH_USER.settings.background_blur"/>
      </InputField>
    </InputSection>

    <InputSection title="Основные настройки">
      <InputField title="Приветственный текст">
        <vs-input v-model="AUTH_USER.settings.description" autocomplete="off">
          <template #icon>
            <i class='bx bx-user'></i>
          </template>
        </vs-input>
      </InputField>
      <InputField title="Основной цвет">
        <div
          class="color__preview rounded shadow"
          @focus="toggleColorPicker('main_color', true)"
          @focusout="toggleColorPicker('main_color', false)"
          tabindex="0"
          :style="{'background-color': AUTH_USER.settings.main_color}">
        <Chrome :value="AUTH_USER.settings.main_color"
                v-if="colorPickers.main_color"
                @input="AUTH_USER.settings.main_color = $event.hex8"/>
        </div>
      </InputField>
    </InputSection>

    <InputSection title="Настройки Кнопки">
      <InputField title="Текст кнопки">
        <vs-input v-model="AUTH_USER.settings.donate_button_text" autocomplete="off">
          <template #icon>
            <i class='bx bx-user'></i>
          </template>
        </vs-input>
      </InputField>
      <InputField title="Цвет текста">
        <div
          class="color__preview rounded shadow"
          @focus="toggleColorPicker('donate_button_text_color', true)"
          @focusout="toggleColorPicker('donate_button_text_color', false)"
          tabindex="0"
          :style="{'background-color': AUTH_USER.settings.donate_button_text_color}"
        >
          <Chrome
            v-model="AUTH_USER.settings.donate_button_text_color"
            v-if="colorPickers.donate_button_text_color"
            @input="AUTH_USER.settings.donate_button_text_color = $event.hex8"
          />
        </div>
      </InputField>
    </InputSection>

    <InputSection title="Настройки доната">
      <InputField title="Минимальная сумма доната">
        <vs-input v-model="AUTH_USER.settings.donation_min_sum" autocomplete="off">
          <template #icon>
            <i class='bx bx-user'></i>
          </template>
        </vs-input>
      </InputField>
      <InputField title="Минимальная сумма доната для медиа">
        <vs-input v-model="AUTH_USER.settings.donation_media_min_sum" autocomplete="off">
          <template #icon>
            <i class='bx bx-user'></i>
          </template>
        </vs-input>
      </InputField>
    </InputSection>

    <InputSection title="Дополнительно">
      <InputField
        title="Включить цели"
        help-text="Пользователь сможет выбрать сбор, в который пойдет донат">
        <vs-switch v-model="AUTH_USER.settings.enabled_donation_goals"/>
      </InputField>
      <InputField
        title="Включить вариации"
        help-text="Пользователю будут доступны вариации донатов на выбор">
        <vs-switch v-model="AUTH_USER.settings.enabled_donation_variations"/>
      </InputField>
      <InputField
        title="Включить медиа"
        help-text="У пользователя появится возможность включить медиа">
        <vs-switch v-model="AUTH_USER.settings.enabled_media"/>
      </InputField>
    </InputSection>

    <div class="row">
      <div class="col-12 col-lg-5">
        <vs-button size="xl" @click="sendForm">
          Сохранить
        </vs-button>
      </div>
    </div>
  </div>
</template>

<script>
import InputField from '@/components/InputField.vue';
import InputSection from '@/components/InputSection.vue';
import HelpInfo from '@/components/HelpInfo.vue';
import DashboardPageTitle from '@/components/DashboardPageTitle.vue';
import RangeSlider from '@/components/@ui/RangeSlider.vue';
import { mapGetters } from 'vuex';
import { Chrome } from 'vue-color';

export default {
  name: 'DonationPageSettings',
  components: {
    InputField,
    DashboardPageTitle,
    InputSection,
    HelpInfo,
    Chrome,
    RangeSlider,
  },
  data() {
    return {
      colorPickers: {
        background_color: false,
        main_color: false,
        donate_button_text_color: false,
      },
      showPreview: false,
    };
  },
  computed: {
    ...mapGetters(['AUTH_USER']),
  },
  methods: {
    toggleColorPicker(colorPicker = 'background_color', show = null) {
      this.colorPickers[colorPicker] = (show) || !this.colorPickers[colorPicker];
    },
    donatePagePreview() {
      localStorage.setItem('donatePagePreview', JSON.stringify(this.AUTH_USER));
      window.open('/preview/donate', 'authWindow', 'width=1200, height=900');
    },
    setPreview() {
      localStorage.setItem('donatePagePreview', JSON.stringify(this.AUTH_USER));
    },
    sendForm() {
      const loading = this.$vs.loading();
      this.$store.dispatch('SAVE_SETTINGS').finally(() => {
        loading.close();
      });
    },
  },
  watch: {
    AUTH_USER: {
      handler() {
        this.setPreview();
      },
      deep: true,
    },
  },
};
</script>

<style scoped lang="scss">
.color__preview {
  width: 30px;
  height: 30px;
  cursor: pointer;
  position: relative;

  .vc-chrome::v-deep {
    top: 3rem;
    position: absolute;
    z-index: 1;
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
