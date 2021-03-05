<template>
  <div v-if="USER_DONATE_PAGE" :style="{backgroundImage: `url(${USER_DONATE_PAGE.settings.background_uri})`}"
       class="donation__page position-relative position-lg-absolute background-center">
    <div :style="cssVars" class="donation__wrapper position-relative position-lg-absolute">
      <div class="container my-5 my-lg-0 m-lg-auto">
        <div class="row mb-5">
          <div class="col">
            <h1 class="user__nickname d-flex align-items-center">
              <span
                :style="{backgroundImage: `url(${USER_DONATE_PAGE.avatar_url})`}"
                class="user__avatar d-inline-flex rounded background-center mr-3">
              </span>
              {{ USER_DONATE_PAGE.name }}
              <SocialNetworkLink
                v-for="socialNetwork in USER_DONATE_PAGE.social_networks"
                :key="socialNetwork.id"
                :link="socialNetwork.pivot.link"
                :type="socialNetwork.title"
                class="ml-4"
              />
            </h1>
            <InfoDescription :text="USER_DONATE_PAGE.settings.description"/>
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-lg-6">
            <form @submit.prevent="sendForm">
              <template v-if="USER_DONATE_PAGE.settings.enabled_donation_variations">
                <InputField
                  v-if="USER_DONATE_PAGE.donation_variations.length !== 0"
                  help-text="Пользователь установил специальные оформления для донатов разной суммы"
                  title="Вариации донатов"
                >
                  <DonationVariations v-model="donation.sum" :variations="USER_DONATE_PAGE.donation_variations"/>
                </InputField>
              </template>
              <InputField title="Ваше имя">
                <vs-input v-model="donation.donation_sender" autocomplete="off" placeholder="Диваныч">
                  <template #icon>
                    <i class='bx bx-user'></i>
                  </template>
                </vs-input>
              </InputField>
              <InputField title="Сумма доната">
                <vs-input v-model="donation.sum" autocomplete="off" placeholder="100">
                  <template #icon>
                    ₽
                  </template>
                  <template v-if="!$v.donation.sum.numeric" #message-warn>
                    Поле должно быть числом
                  </template>
                  <template v-if="!$v.donation.sum.required" #message-danger>
                    Обязательное поле
                  </template>
                  <template v-if="!$v.donation.sum.minValue" #message-warn>
                    Минимальная сумма -
                    {{ USER_DONATE_PAGE.settings.donation_min_sum }}
                    ₽
                  </template>
                </vs-input>
              </InputField>
              <InputField title="Текст сообщения">
                <vs-input v-model="donation.text" autocomplete="off" placeholder="Ты топчик!">
                  <template #icon>
                    <i class='bx bx-comment-detail'></i>
                  </template>
                </vs-input>
              </InputField>
            </form>
          </div>
          <div class="offset-lg-1 col-12 col-lg-5 mt-2 mt-lg-0">
            <template v-if="USER_DONATE_PAGE.settings.enabled_donation_goals">
              <InputField
                v-if="USER_DONATE_PAGE.donation_goals.length !== 0"
                help-text="Пользователь установил сборы на цели"
                title="Цели сбора"
              >
                <div class="center d-flex flex-column align-items-start">
                  <vs-radio v-model="donation.goal_id"
                            :val="null"
                            class="mb-2">
                    Без цели
                  </vs-radio>
                  <vs-radio v-for="donation_goal in USER_DONATE_PAGE.donation_goals"
                            :key="donation_goal.id"
                            v-model="donation.goal_id"
                            :val="donation_goal.id"
                            class="mb-2">
                    {{ donation_goal.title }}
                  </vs-radio>
                </div>
              </InputField>
            </template>
            <template v-if="USER_DONATE_PAGE.settings.enabled_media">
              <InputField
                help-text="При донате у пользователя будет воспроизведено медиа"
                title="Медиа"
              >
                <vs-input :disabled="donation.sum < USER_DONATE_PAGE.settings.donation_media_min_sum"
                          autocomplete="off"
                          placeholder="Ссылка на видео">
                  <template #icon>
                    <i class='bx bxl-youtube'></i>
                  </template>
                  <template v-if="donation.sum < USER_DONATE_PAGE.settings.donation_media_min_sum"
                            #message-warn>
                    Минимальная сумма для медиа -
                    {{ USER_DONATE_PAGE.settings.donation_media_min_sum }}₽
                  </template>
                </vs-input>
              </InputField>
            </template>
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-lg-5">
            <vs-button :disabled="$v.$invalid" :style="{'color': USER_DONATE_PAGE.settings.donate_button_text_color}"
                       size="xl">
              {{ USER_DONATE_PAGE.settings.donate_button_text }}
            </vs-button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import 'vue-slick-carousel/dist/vue-slick-carousel.css';
import 'vue-slick-carousel/dist/vue-slick-carousel-theme.css';
import InputField from '@/components/@ui/InputFieldComponent.vue';
import DonationVariations from '@/components/DonationVariationsComponent.vue';
import InfoDescription from '@/components/@ui/InfoDescriptionComponent.vue';
import SocialNetworkLink from '@/components/SocialNetworkLinkComponent.vue';
import { minValue, numeric, required } from 'vuelidate/lib/validators';
import { HEXtoRGB } from '@/helpers/color';

export default {
  name: 'donation',
  components: {
    InputField,
    DonationVariations,
    InfoDescription,
    SocialNetworkLink,
  },
  data() {
    return {
      USER_DONATE_PAGE: {},
      donation: {
        text: '',
        donation_sender: '',
        sum: '',
        goal_id: null,
      },
    };
  },
  validations() {
    return {
      donation: {
        sum: {
          required,
          minValue: minValue(this.USER_DONATE_PAGE.settings.donation_min_sum),
          numeric,
        },
      },
    };
  },
  mounted() {
    this.updatePreview();
    setInterval(() => {
      this.updatePreview();
    }, 100);
    window.addEventListener('beforeunload', () => {
      localStorage.removeItem('donatePagePreview');
    });
  },
  methods: {
    updatePreview() {
      this.USER_DONATE_PAGE = JSON.parse(localStorage.getItem('donatePagePreview'));
    },
  },
  computed: {
    cssVars() {
      return {
        '--vs-primary': HEXtoRGB(this.USER_DONATE_PAGE.settings.main_color),
        'backdrop-filter': `blur(${this.USER_DONATE_PAGE.settings.background_blur}px)`,
        background: this.USER_DONATE_PAGE.settings.background_color,
      };
    }
    ,
  },
};
</script>

<style lang="scss" scoped>
.donation__page {
  height: 100%;
  width: 100%;

  .user__nickname {
    .user__avatar {
      width: 2.5rem;
      height: 2.5rem;
    }

    font-family: 'Montserrat', sans-serif;
    font-weight: 700;
  }

  .donation__wrapper {
    display: flex;
    backdrop-filter: blur(2px);
    background: rgba(255, 255, 255, .8);

    & > .container {
      margin: auto;
    }
  }
}
</style>
