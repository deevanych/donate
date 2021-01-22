<template>
  <div class="donation__page position-lg-absolute" :style="{backgroundImage: `url(${$store.getters.getDonatePageSettings('background_uri')})`}">
    <div class="donation__wrapper" :style="cssVars">
      <div class="container my-5 my-lg-0 m-lg-auto">
        <div class="row mb-5">
          <div class="col">
            <h1 class="nickname">{{ $store.getters.getDonatePageSettings('nickname') }}</h1>
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-lg-6">
            <form @submit.prevent="sendForm">
              <template v-if="$store.getters.getDonatePageSettings('enabled_donation_variations')">
                <DonationSection v-if="user.donation_variations.length !== 0" title="Вариации донатов">
                  <DonationVariations v-model="donation.sum" :variations="user.donation_variations"/>
                </DonationSection>
              </template>
              <DonationSection title="Ваше имя">
                <vs-input v-model="donation.donation_sender" placeholder="Диваныч" autocomplete="off">
                  <template #icon>
                    <i class='bx bx-user'></i>
                  </template>
                </vs-input>
              </DonationSection>
              <DonationSection title="Сумма доната">
                <vs-input v-model="donation.sum" placeholder="100" autocomplete="off">
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
                    {{ $store.getters.getDonatePageSettings('donation_min_sum') }}
                    ₽
                  </template>
                </vs-input>
              </DonationSection>
              <DonationSection title="Текст сообщения">
                <vs-input v-model="donation.text" placeholder="Ты топчик!" autocomplete="off">
                  <template #icon>
                    <i class='bx bx-comment-detail'></i>
                  </template>
                </vs-input>
              </DonationSection>
            </form>
          </div>
          <div class="offset-lg-1 col-12 col-lg-5 mt-2 mt-lg-0">
            <template v-if="$store.getters.getDonatePageSettings('enabled_donation_goals')">
              <DonationSection v-if="user.donation_goals.length !== 0" title="Цели сбора">
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
              </DonationSection>
            </template>
            <template v-if="$store.getters.getDonatePageSettings('enabled_media')">
              <DonationSection title="Медиа">
                <vs-input placeholder="Ссылка на видео"
                          :disabled="donation.sum < $store.getters.getDonatePageSettings('donation_media_min_sum')"
                          autocomplete="off">
                  <template #icon>
                    <i class='bx bxl-youtube'></i>
                  </template>
                  <template v-if="donation.sum < $store.getters.getDonatePageSettings('donation_media_min_sum')"
                            #message-warn>
                    Минимальная сумма для медиа -
                    {{ $store.getters.getDonatePageSettings('donation_media_min_sum') }}₽
                  </template>
                </vs-input>
              </DonationSection>
            </template>
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-lg-5">
            <vs-button size="xl" :disabled="$v.$invalid">
              {{ $store.getters.getDonatePageSettings('donate_button_text') }}
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
import DonationSection from '@/components/DonationSection.vue';
import DonationVariations from '@/components/DonationVariations.vue';
import { required, minValue, numeric } from 'vuelidate/lib/validators';
import user from '@/api/user';
import donation from '@/api/donation';
import { HEXtoRGB } from '@/helpers/color';

let loading = '';

export default {
  name: 'donation',
  components: {
    DonationSection,
    DonationVariations,
  },
  data() {
    return {
      user: {
        name: null,
        donation_variations: [],
        donation_goals: [],
      },
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
          minValue: minValue(this.$store.getters.getDonatePageSettings('donation_min_sum')),
          numeric,
        },
      },
    };
  },
  mounted() {
    const self = this;
    loading = this.$vs.loading();
    user.get(self.$route.params.user, this.setUser);
  },
  computed: {
    cssVars() {
      return {
        '--vs-primary': HEXtoRGB(this.$store.getters.getDonatePageSettings('main_color')),
      };
    },
  },
  methods: {
    setUser(data) {
      this.user = data.data;
      this.donation.sum = data.data.settings.donation_min_sum;
      this.$store.dispatch('setDonatePageSettings', data.data.settings);
      this.$store.dispatch('setDonatePageSettings', { nickname: data.data.name }).then(() => {
        loading.close();
      });
    },
    donationNotification(text = 'Счастья, здоровья!', border = 'success', title = 'Донат отправлен') {
      this.$vs.notification({
        position: 'top-right',
        border,
        title,
        text,
      });
    },
    successNotification(data) {
      loading.close();
      if (data.data.status === 'error') {
        this.donationNotification(data.data.message, 'danger', 'Произошла ошибка');
      } else {
        this.donationNotification(data.data.message);
      }
    },
    errorNotification(data) {
      loading.close();
      this.donationNotification(data, 'danger', 'Произошла ошибка');
    },
    sendForm() {
      loading = this.$vs.loading();
      donation.send(
        this.$route.params.user,
        this.donation,
        this.successNotification,
        this.errorNotification,
      );
    },
  },
};
</script>

<style scoped lang="scss">
.donation__page {
  position: absolute;
  height: 100%;
  width: 100%;
  background-position: center;
  background-size: cover;

  .nickname {
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
