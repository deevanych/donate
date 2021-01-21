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
            <DonationSection title="Вариации донатов">
              <DonationVariations v-model="donate.sum" :variations="donationVariations"/>
            </DonationSection>
            <DonationSection title="Ваше имя">
              <vs-input border v-model="donate.donation_sender" placeholder="Диваныч">
                <template #icon>
                  <i class='bx bx-user'></i>
                </template>
              </vs-input>
            </DonationSection>
            <DonationSection title="Сумма доната">
              <vs-input border v-model="donate.sum" placeholder="100">
                <template #icon>
                  ₽
                </template>
              </vs-input>
            </DonationSection>
            <DonationSection title="Текст сообщения">
              <vs-input border v-model="donate.text" placeholder="Ты топчик!">
                <template #icon>
                  <i class='bx bx-comment-detail'></i>
                </template>
              </vs-input>
            </DonationSection>
            <vs-button size="xl">
              Отправить
            </vs-button>
          </form>
        </div>
        <div class="col-5 offset-1">
          <!--          <h5>Цель сбора</h5>-->
          <!--          <div class="center">-->
          <!--            <vs-radio v-model="donate.goal_id" :val="null">-->
          <!--              Без цели-->
          <!--            </vs-radio>-->
          <!--            <vs-radio v-model="donate.goal_id" :val="1">-->
          <!--              На кресло-->
          <!--            </vs-radio>-->
          <!--            <vs-radio v-model="donate.goal_id" :val="2">-->
          <!--              На любовницу-->
          <!--            </vs-radio>-->
          <!--            <vs-radio v-model="donate.goal_id" :val="3">-->
          <!--              На камеру-->
          <!--            </vs-radio>-->
          <!--          </div>-->
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

let loading = '';

export default {
  name: 'Donate',
  components: {
    DonationSection,
    DonationVariations,
  },
  data: () => ({
    user: {
      name: null,
    },
    donate: {
      text: 'Ты суперкласс!',
      donation_sender: 'Лолита',
      sum: 300,
      // goal_id: null,
    },
    donationVariations: [
      {
        id: 1,
        sum: 100,
        description: 'минимум',
      },
      {
        id: 2,
        sum: 666,
        description: 'скример',
      },
      {
        id: 3,
        sum: 1000,
        description: 'стриптиз',
      },
      {
        id: 4,
        sum: 2000,
        description: 'танцую',
      },
      {
        id: 5,
        sum: 5000,
        description: 'делаю тату',
      },
      {
        id: 6,
        sum: 10000,
        description: 'показываю то самое',
      },
    ],
    showDialog: true,
  }),
  mounted() {
    const self = this;
    const utterance = new SpeechSynthesisUtterance('Hello world!');
    speechSynthesis.speak(utterance);
    self.$http.get(`users/${self.$route.params.user}`)
      .then((response) => {
        self.user = response.data;
      });
  },
  methods: {
    donateNotification(text = 'Счастья, здоровья!', border = 'success', title = 'Донат отправлен') {
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
      self.$http.post(`users/${self.$route.params.user}/donations`, self.donate)
        .then((response) => {
          if (response.data.status === 'error') {
            self.donateNotification(response.data.message, 'danger', 'Произошла ошибка');
          } else {
            self.donateNotification(response.data.message);
          }
        })
        .catch((error) => {
          self.donateNotification(error.data.message, 'danger', 'Произошла ошибка');
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
  background: url("https://get.wallhere.com/photo/1920x1080-px-Dota-fantasy-art-Lina-1260795.jpg");
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
