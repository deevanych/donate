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
    <InputSection title="Настройки фона">
      <InputField title="Фоновое изображение">
        <vs-input v-model="USER.settings.background_uri" autocomplete="off">
          <template #icon>
            <i class='bx bx-image-alt'></i>
          </template>
        </vs-input>
      </InputField>
      <InputField title="Фоновый цвет">
        <div
          class="color__preview rounded shadow"
          @focus="toggleColorPicker('background_color', true)"
          @focusout="toggleColorPicker('background_color', false)"
          tabindex="0"
          :style="{'background-color': USER.settings.background_color}"
        >
          <Chrome
            v-model="USER.settings.background_color"
            v-if="colorPickers.background_color"
            @input="USER.settings.background_color = $event.hex8"
          />
        </div>
      </InputField>
      <InputField title="Размытие изображения">
        <div class="d-flex align-items-center">
          <vs-input v-model="USER.settings.background_blur" autocomplete="off" class="settings__background-blur">
            <template #icon>
              <i class='bx bx-brush' ></i>
            </template>
          </vs-input>
          <span class="mr-4 ml-1">px</span>
          <RangeSlider
            v-model="USER.settings.background_blur"
            width="100px"
            :min="0"
          />
        </div>
      </InputField>
    </InputSection>

    <InputSection title="Основные настройки">
      <InputField title="Приветственный текст">
        <vs-input v-model="USER.settings.description" autocomplete="off">
          <template #icon>
            <i class='bx bx-text' ></i>
          </template>
        </vs-input>
      </InputField>
      <InputField title="Основной цвет">
        <div
          class="color__preview rounded shadow"
          @focus="toggleColorPicker('main_color', true)"
          @focusout="toggleColorPicker('main_color', false)"
          tabindex="0"
          :style="{'background-color': USER.settings.main_color}">
          <Chrome :value="USER.settings.main_color"
                  v-if="colorPickers.main_color"
                  @input="USER.settings.main_color = $event.hex8"/>
        </div>
      </InputField>
    </InputSection>

    <InputSection title="Настройки Кнопки">
      <InputField title="Текст кнопки">
        <vs-input v-model="USER.settings.donate_button_text" autocomplete="off">
          <template #icon>
            <i class='bx bx-text' ></i>
          </template>
        </vs-input>
      </InputField>
      <InputField title="Цвет текста">
        <div
          class="color__preview rounded shadow"
          @focus="toggleColorPicker('donate_button_text_color', true)"
          @focusout="toggleColorPicker('donate_button_text_color', false)"
          tabindex="0"
          :style="{'background-color': USER.settings.donate_button_text_color}"
        >
          <Chrome
            v-model="USER.settings.donate_button_text_color"
            v-if="colorPickers.donate_button_text_color"
            @input="USER.settings.donate_button_text_color = $event.hex8"
          />
        </div>
      </InputField>
    </InputSection>

    <InputSection title="Настройки доната">
      <InputField title="Минимальная сумма доната">
        <vs-input v-model="USER.settings.donation_min_sum" autocomplete="off">
          <template #icon>
            <i class='bx bx-money' ></i>
          </template>
        </vs-input>
      </InputField>
      <InputField title="Минимальная сумма доната для медиа">
        <vs-input v-model="USER.settings.donation_media_min_sum" autocomplete="off">
          <template #icon>
            <i class='bx bx-money' ></i>
          </template>
        </vs-input>
      </InputField>
    </InputSection>

    <InputSection title="Дополнительно">
      <InputField
        title="Включить цели"
        help-text="Пользователь сможет выбрать сбор, в который пойдет донат">
        <vs-switch v-model="USER.settings.enabled_donation_goals">
          <template #off>
            <i class='bx bx-x' ></i>
          </template>
          <template #on>
            <i class='bx bx-check' ></i>
          </template>
        </vs-switch>
      </InputField>
      <InputField
        title="Включить вариации"
        help-text="Пользователю будут доступны вариации донатов на выбор">
        <vs-switch v-model="USER.settings.enabled_donation_variations">
          <template #off>
            <i class='bx bx-x' ></i>
          </template>
          <template #on>
            <i class='bx bx-check' ></i>
          </template>
        </vs-switch>
      </InputField>
      <InputField
        title="Включить медиа"
        help-text="У пользователя появится возможность включить медиа">
        <vs-switch v-model="USER.settings.enabled_media">
          <template #off>
            <i class='bx bx-x' ></i>
          </template>
          <template #on>
            <i class='bx bx-check' ></i>
          </template>
        </vs-switch>
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
    };
  },
  computed: {
    ...mapGetters(['USER']),
  },
  mounted() {
    // const loading = this.$vs.loading();
    // this.$store.dispatch('GET_SETTINGS').finally(() => {
    //   loading.close();
    // });
  },
  methods: {
    toggleColorPicker(colorPicker = 'background_color', show = null) {
      this.colorPickers[colorPicker] = (show) || !this.colorPickers[colorPicker];
    },
    donatePagePreview() {
      localStorage.setItem('donatePagePreview', JSON.stringify(this.USER));
      window.open('/preview/donate', 'authWindow', 'width=1200, height=900');
    },
    setPreview() {
      localStorage.setItem('donatePagePreview', JSON.stringify(this.USER));
    },
    sendForm() {
      const loading = this.$vs.loading();
      this.$store.dispatch('SAVE_SETTINGS').finally(() => {
        this.loaded = true;
        loading.close();
      });
    },
  },
  watch: {
    USER: {
      handler() {
        this.setPreview();
      },
      deep: true,
    },
  },
};
</script>

<style scoped lang="scss">
.settings__background-blur {
  width: 90px;
}

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
