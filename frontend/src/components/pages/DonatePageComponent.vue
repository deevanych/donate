<template>
  <div :style="{backgroundImage: `url(${user.settings.background_uri})`}"
       class="donation__page position-relative position-lg-absolute background-center">
    <VueHeadFul
      :title="pageTitle"
    />
    <div :style="cssVars" class="donation__wrapper position-relative position-lg-absolute">
      <div class="container my-5 my-lg-0 m-lg-auto">
        <div class="row mb-5">
          <div class="col">
            <h1 class="user__nickname d-flex align-items-center">
              <span
                :style="{backgroundImage: `url(${user.avatar_url})`}"
                class="user__avatar d-inline-flex rounded background-center mr-3">
              </span>
              {{ user.name }}
              <SocialNetworkLink
                v-for="socialNetwork in user.social_networks"
                :key="socialNetwork.id"
                :link="socialNetwork.pivot.link"
                :type="socialNetwork.title"
                class="ml-4"
              />
            </h1>
            <InfoDescription :text="user.settings.description"/>
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-lg-6">
            <form @submit.prevent="sendForm">
              <template v-if="user.settings.enabled_donation_variations">
                <InputField
                  v-if="user.donation_variations.length !== 0"
                  help-text="Пользователь установил специальные оформления для донатов разной суммы"
                  title="Вариации донатов"
                >
                  <div class="col">
                    <DonationVariations v-model="donation.sum" :variations="user.donation_variations"/>
                  </div>
                </InputField>
              </template>
              <InputField title="Ваше имя">
                <div class="col">
                  <vs-input v-model="donation.donation_sender" autocomplete="off" placeholder="Диваныч">
                    <template #icon>
                      <i class='bx bx-user'></i>
                    </template>
                  </vs-input>
                </div>
              </InputField>
              <InputField title="Сумма доната">
                <div class="col">
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
                      {{ user.settings.donation_min_sum }}
                      ₽
                    </template>
                  </vs-input>
                </div>
              </InputField>
              <InputField title="Текст сообщения">
                <div class="col">
                  <vs-input v-model="donation.text" autocomplete="off" placeholder="Ты топчик!">
                    <template #icon>
                      <i class='bx bx-comment-detail'></i>
                    </template>
                    <template v-if="!$v.donation.text.maxLength" #message-warn>
                      Превышено максимальное количество знаков
                    </template>
                  </vs-input>
                </div>
              </InputField>
            </form>
          </div>
          <div class="offset-lg-1 col-12 col-lg-5 mt-2 mt-lg-0">
            <template v-if="user.settings.enabled_donation_goals">
              <InputField
                v-if="user.donation_goals.length !== 0"
                help-text="Пользователь установил сборы на цели"
                title="Цели сбора"
              >
                <div class="col">
                  <div class="center d-flex flex-column align-items-start">
                    <vs-radio v-model="donation.goal_id"
                              :val="null"
                              class="mb-2">
                      Без цели
                    </vs-radio>
                    <vs-radio v-for="donation_goal in user.donation_goals"
                              :key="donation_goal.id"
                              v-model="donation.goal_id"
                              :val="donation_goal.id"
                              class="mb-2">
                      {{ donation_goal.title }}
                    </vs-radio>
                  </div>
                </div>
              </InputField>
            </template>
            <template v-if="user.settings.enabled_media">
              <InputField
                help-text="При донате у пользователя будет воспроизведено медиа"
                title="Медиа"
              >
                <div class="col">
                  <vs-input v-model="donation.media"
                            :disabled="parseInt(donation.sum, 0) < user.settings.donation_media_min_sum"
                            autocomplete="off"
                            placeholder="Ссылка на видео"
                            @input="checkVideo">
                    <template #icon>
                      <i class='bx bxl-youtube'></i>
                    </template>
                    <template v-if="parseInt(donation.sum, 0) < user.settings.donation_media_min_sum"
                              #message-warn>
                      Минимальная сумма для медиа -
                      {{ user.settings.donation_media_min_sum }}₽
                    </template>
                    <template #message-danger>
                      <div>
                        <div v-if="mediaErrors.likes_ratio">
                          Неподходящее соотношение лайков/дизлайков
                        </div>
                        <div v-if="mediaErrors.broadcasting">
                          Это трансляция!
                        </div>
                        <div v-if="mediaErrors.adult">
                          Возрастное ограничение
                        </div>
                        <div v-if="mediaErrors.embed_not_allowed">
                          Это видео запрещено встраивать
                        </div>
                        <div v-if="mediaErrors.view_count">
                          Неподходящее количество просмотров
                        </div>
                        <div v-if="!$v.mediaErrors.not_found">
                          Видео не найдено
                        </div>
                      </div>
                    </template>
                  </vs-input>
                </div>
              </InputField>
            </template>
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-lg-5">
            <vs-button :disabled="$v.$invalid" :style="{'color': user.settings.donate_button_text_color}"
                       size="xl"
                       @click="sendForm"
                       class="m-0">
              {{ user.settings.donate_button_text }}
            </vs-button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import InputField from '@/components/@ui/InputFieldComponent.vue';
import DonationVariations from '@/components/DonationVariationsComponent.vue';
import InfoDescription from '@/components/@ui/InfoDescriptionComponent.vue';
import SocialNetworkLink from '@/components/SocialNetworkLinkComponent.vue';
import {
  maxLength, minValue, numeric, required,
} from 'vuelidate/lib/validators';
import { HEXtoRGB } from '@/helpers/color';
import { sendDonation } from '@/api/donations';
import { donationType } from '@/types/donations';

let loading;

function initialMediaErrors() {
  return {
    adult: false,
    likes_ratio: false,
    embed_not_allowed: false,
    broadcasting: false,
    view_count: false,
    not_found: false,
  };
}

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
      donation: donationType,
      mediaErrors: initialMediaErrors(),
    };
  },
  props: {
    user: {
      required: true,
      type: Object,
    },
  },
  validations() {
    return {
      donation: {
        sum: {
          required,
          minValue: minValue(this.user.settings.donation_min_sum),
          numeric,
        },
        text: {
          maxLength: maxLength(100),
        },
      },
      mediaErrors: {
        adult: (value) => value.adult === false,
        likes_ratio: (value) => value.likes_ratio === false,
        embed_not_allowed: (value) => value.embed_not_allowed === false,
        broadcasting: (value) => value.broadcasting === false,
        view_count: (value) => value.view_count === false,
        not_found: (value) => value.not_found === false,
      },
    };
  },
  computed: {
    cssVars() {
      const color = JSON.parse(this.user.settings.background_color);
      const gradientColors = [];

      Object.keys(color.stops).forEach((key) => {
        gradientColors.push(`${color.stops[key][0]} ${color.stops[key][1] * 100}%`);
      });

      return {
        '--vs-primary': HEXtoRGB(this.user.settings.main_color),
        'backdrop-filter': `blur(${this.user.settings.background_blur}px)`,
        background: `linear-gradient(${color.angle}deg, ${gradientColors.join(', ')})`,
      };
    },
    pageTitle() {
      return `${this.user.name} - ezdonate.ru`;
    },
  },
  methods: {
    sendForm() {
      loading = this.$vs.loading();
      sendDonation(this.$route.params.user, this.donation)
        .then(({ data }) => {
          this.$vs.notification({
            position: 'top-right',
            border: data.status,
            title: data.message,
            text: 'Донат успешно отправлен',
          });
        })
        .finally(() => {
          loading.close();
        });
    },
    checkVideo() {
      Object.assign(this.mediaErrors, initialMediaErrors());
      if (this.donation.media.length > 0) {
        this.$http(`/video?uri=${this.donation.media}`).then((res) => {
          res.data.forEach((error) => {
            this.mediaErrors[error] = true;
          });
        });
      }
    },
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

    font-weight: 700;
  }

  .donation__wrapper {
    display: flex;

    & > .container {
      margin: auto;
    }
  }
}
</style>
