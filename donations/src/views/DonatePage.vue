<template>
  <div class="donation__wrapper">
    <div class="container">
      <div class="row mb-5">
        <div class="col">
          <h1>{{ user.name }}</h1>
        </div>
      </div>
      <div class="row">
        <div class="col-6">
          <form @submit.prevent="sendForm">
            <DonationSection v-if="user.donation_variations.length !== 0" title="Вариации донатов">
              <DonationVariations v-model="donation.sum" :variations="user.donation_variations"/>
            </DonationSection>
            <DonationSection title="Ваше имя">
              <vs-input border v-model="donation.donation_sender" placeholder="Диваныч">
                <template #icon>
                  <i class='bx bx-user'></i>
                </template>
              </vs-input>
            </DonationSection>
            <DonationSection title="Сумма доната">
              <vs-input border v-model="donation.sum" placeholder="100">
                <template #icon>
                  ₽
                </template>
                <template v-if="!$v.donation.sum.minValue" #message-warn>
                  Минимальная сумма - 100₽
                </template>
                <template v-if="!$v.donation.sum.numeric" #message-warn>
                  Поле должно быть числом
                </template>
                <template v-if="!$v.donation.sum.required" #message-danger>
                  Обязательное поле
                </template>
              </vs-input>
            </DonationSection>
            <DonationSection title="Текст сообщения">
              <vs-input border v-model="donation.text" placeholder="Ты топчик!">
                <template #icon>
                  <i class='bx bx-comment-detail'></i>
                </template>
              </vs-input>
            </DonationSection>
            <vs-button size="xl" :disabled="$v.$invalid">
              Отправить
            </vs-button>
          </form>
        </div>
        <div class="col-5 offset-1">
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
        text: 'Ты суперкласс!',
        donation_sender: 'Лолита',
        sum: 300,
        goal_id: null,
      },
      showDialog: true,
    };
  },
  validations: {
    donation: {
      sum: {
        required,
        minValue: minValue(100),
        numeric,
      },
    },
  },
  mounted() {
    const self = this;
    self.$http.get(`users/${self.$route.params.user}`)
      .then((response) => {
        self.user = response.data;
      });
  },
  methods: {
    donationNotification(text = 'Счастья, здоровья!', border = 'success', title = 'Донат отправлен') {
      this.$vs.notification({
        position: 'top-right',
        border,
        title,
        text,
      });
    },
    sendForm() {
      loading = this.$vs.loading();
      const self = this;
      self.$http.post(`users/${self.$route.params.user}/donations`, self.donation)
        .then((response) => {
          if (response.data.status === 'error') {
            self.donationNotification(response.data.message, 'danger', 'Произошла ошибка');
          } else {
            self.donationNotification(response.data.message);
          }
        })
        .catch((error) => {
          self.donationNotification(error.data.message, 'danger', 'Произошла ошибка');
        })
        .finally(() => {
          loading.close();
        });
    },
  },
};
</script>

<style lang="scss">
body {
  background: url("https://static.donationalerts.ru/uploads/images/3107503/1588490770_39-p-prostie-rozovie-foni-89.jpg");
}
</style>

<style scoped lang="scss">
.donation__wrapper {
  display: flex;
  backdrop-filter: blur(2px);
  background: rgba(255, 255, 255, .8);

  & > .container {
    margin: auto;
  }
}
</style>
