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
                  Минимальная сумма - 100₽
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
          <DonationSection title="Медиа">
            <vs-input placeholder="Ссылка на видео"
                      :disabled="donation.sum < 150"
                      autocomplete="off">
              <template #icon>
                <i class='bx bxl-youtube'></i>
              </template>
              <template v-if="donation.sum < 150" #message-warn>
                Минимальная сумма для медиа - 150₽
              </template>
            </vs-input>
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
import user from '@/api/user';
import donation from '@/api/donation';

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
    user.get(self.$route.params.user, this.setUser);
  },
  methods: {
    setUser(data) {
      this.user = data.data;
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
