<template>
  <div>
    <VueHeadFul
      :title="pageTitle"
    />
    <DashboardPageTitle
      :title="pageTitle"
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
        <vs-input v-model="SETTINGS.background_uri" autocomplete="off">
          <template #icon>
            <i class='bx bx-image-alt'></i>
          </template>
        </vs-input>
      </InputField>
      <InputField title="Фоновый цвет">
        <ColorPicker v-model="SETTINGS.background_color"/>
      </InputField>
      <InputField title="Размытие изображения">
        <div class="d-flex align-items-center">
          <RangeSlider
            v-model="SETTINGS.background_blur"
            :min="0"
            :max="100"
            :width="200"
            tooltip="hover"
          />
        </div>
      </InputField>
    </InputSection>

    <InputSection title="Основные настройки">
      <InputField title="Приветственный текст">
        <vs-input v-model="SETTINGS.description" autocomplete="off">
          <template #icon>
            <i class='bx bx-text' ></i>
          </template>
        </vs-input>
      </InputField>
      <InputField title="Основной цвет">
        <ColorPicker v-model="SETTINGS.main_color"/>
      </InputField>
    </InputSection>

    <InputSection title="Настройки кнопки">
      <InputField title="Текст кнопки">
        <vs-input v-model="SETTINGS.donate_button_text" autocomplete="off">
          <template #icon>
            <i class='bx bx-text' ></i>
          </template>
        </vs-input>
      </InputField>
      <InputField title="Цвет текста">
        <ColorPicker v-model="SETTINGS.donate_button_text_color"/>
      </InputField>
    </InputSection>

    <InputSection title="Настройки доната">
      <InputField title="Минимальная сумма доната">
        <vs-input v-model="SETTINGS.donation_min_sum" autocomplete="off">
          <template #icon>
            <i class='bx bx-money' ></i>
          </template>
        </vs-input>
      </InputField>
      <InputField title="Минимальная сумма доната для медиа">
        <vs-input v-model="SETTINGS.donation_media_min_sum" autocomplete="off">
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
        <vs-switch v-model="SETTINGS.enabled_donation_goals">
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
        <vs-switch v-model="SETTINGS.enabled_donation_variations">
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
        <vs-switch v-model="SETTINGS.enabled_media">
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
import RangeSlider from 'vue-range-component-fixed';
import ColorPicker from '@/components/@ui/ColorPicker.vue';
import { mapGetters } from 'vuex';

let loading;

export default {
  name: 'DonationPageSettings',
  components: {
    InputField,
    DashboardPageTitle,
    InputSection,
    HelpInfo,
    ColorPicker,
    RangeSlider,
  },
  data() {
    return {
      pageTitle: 'Страница доната',
    };
  },
  computed: {
    ...mapGetters(['SETTINGS']),
  },
  mounted() {
    loading = this.$vs.loading();
    this.$store.dispatch('GET_SETTINGS').finally(() => {
      loading.close();
    });
  },
  methods: {
    donatePagePreview() {
      localStorage.setItem('donatePagePreview', JSON.stringify(this.USER));
      window.open('/preview/donate', 'authWindow', 'width=1200, height=900');
    },
    setPreview() {
      localStorage.setItem('donatePagePreview', JSON.stringify(this.USER));
    },
    sendForm() {
      loading = this.$vs.loading();
      this.$store.dispatch('SAVE_SETTINGS').finally(() => {
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
</style>
