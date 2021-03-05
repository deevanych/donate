<template>
  <div>
    <VueHeadFul
      :title="pageTitle"
    />
    <DashboardPageTitle
      :title="pageTitle"
      description="Настрой страницу под себя">
      <vs-button border
                 class="flex-shrink-0"
                 size="large"
                 @click="donatePagePreview">
        Превью
        <HelpInfo
          class="ml-2"
          text="Откроется страница донатов в новом окне, которая будет отображать ваши изменения в реальном времени. Меняйте настройки тут и сразу же смотрите результат там."/>
      </vs-button>
    </DashboardPageTitle>
    <InputSection title="Настройки фона">
      <InputField title="Фоновое изображение">
        <div class="col">
        <vs-input v-model="SETTINGS.background_uri" autocomplete="off">
          <template #icon>
            <i class='bx bx-image-alt'></i>
          </template>
        </vs-input>
        </div>
      </InputField>
      <InputField title="Фоновый цвет">
        <div class="col">
          <ColorPicker v-model="SETTINGS.background_color"/>
        </div>
      </InputField>
      <InputField title="Размытие изображения">
        <div class="col">
          <div class="d-flex align-items-center">
            <RangeSlider
              v-model="SETTINGS.background_blur"
              :max="100"
              :min="0"
              :width="200"
              tooltip="hover"
            />
          </div>
        </div>
      </InputField>
    </InputSection>

    <InputSection title="Основные настройки">
      <InputField title="Приветственный текст">
        <div class="col">
          <vs-input v-model="SETTINGS.description" autocomplete="off">
            <template #icon>
              <i class='bx bx-text'></i>
            </template>
          </vs-input>
        </div>
      </InputField>
      <InputField title="Основной цвет">
        <div class="col">
          <ColorPicker v-model="SETTINGS.main_color" :gradient="false"/>
        </div>
      </InputField>
    </InputSection>

    <InputSection title="Настройки кнопки">
      <InputField title="Текст кнопки">
        <div class="col">
        <vs-input v-model="SETTINGS.donate_button_text" autocomplete="off">
          <template #icon>
            <i class='bx bx-text'></i>
          </template>
        </vs-input>
        </div>
      </InputField>
      <InputField title="Цвет текста">
        <div class="col">
        <ColorPicker v-model="SETTINGS.donate_button_text_color" :gradient="false"/>
        </div>
      </InputField>
    </InputSection>

    <InputSection title="Настройки доната">
      <InputField title="Минимальная сумма доната">
        <div class="col">
        <vs-input v-model="SETTINGS.donation_min_sum" autocomplete="off">
          <template #icon>
            <i class='bx bx-money'></i>
          </template>
        </vs-input>
        </div>
      </InputField>
      <InputField title="Минимальная сумма доната для медиа">
        <div class="col">
        <vs-input v-model="SETTINGS.donation_media_min_sum" autocomplete="off">
          <template #icon>
            <i class='bx bx-money'></i>
          </template>
        </vs-input>
        </div>
      </InputField>
    </InputSection>

    <InputSection title="Дополнительно">
      <InputField
        help-text="Пользователь сможет выбрать сбор, в который пойдет донат"
        title="Включить цели">
        <div class="col">
        <vs-switch v-model="SETTINGS.enabled_donation_goals">
          <template #off>
            <i class='bx bx-x'></i>
          </template>
          <template #on>
            <i class='bx bx-check'></i>
          </template>
        </vs-switch>
        </div>
      </InputField>
      <InputField
        help-text="Пользователю будут доступны вариации донатов на выбор"
        title="Включить вариации">
        <div class="col">
        <vs-switch v-model="SETTINGS.enabled_donation_variations">
          <template #off>
            <i class='bx bx-x'></i>
          </template>
          <template #on>
            <i class='bx bx-check'></i>
          </template>
        </vs-switch>
        </div>
      </InputField>
      <InputField
        help-text="У пользователя появится возможность включить медиа"
        title="Включить медиа">
        <div class="col">
        <vs-switch v-model="SETTINGS.enabled_media">
          <template #off>
            <i class='bx bx-x'></i>
          </template>
          <template #on>
            <i class='bx bx-check'></i>
          </template>
        </vs-switch>
        </div>
      </InputField>
    </InputSection>

    <div class="row pl-3">
      <div class="col-12 col-lg-5">
        <vs-button size="xl" @click="sendForm">
          Сохранить
        </vs-button>
      </div>
    </div>
  </div>
</template>

<script>
import InputField from '@/components/@ui/InputFieldComponent.vue';
import InputSection from '@/components/@ui/InputSectionComponent.vue';
import HelpInfo from '@/components/@ui/HelpInfoComponent.vue';
import DashboardPageTitle from '@/components/pages/dashboard/DashboardPageTitleComponent.vue';
import RangeSlider from 'vue-range-component-fixed';
import ColorPicker from '@/components/@ui/ColorPickerComponent.vue';
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
      this.$store.dispatch('SAVE_SETTINGS').then(({ data }) => {
        this.$vs.notification({
          position: 'top-right',
          border: 'success',
          title: data.message,
          text: 'Настройки успешно сохранены',
        });
      }).finally(() => {
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
