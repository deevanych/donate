<template>
  <div class="container">
    <div class="row mb-5">
      <div class="col">
        <h1>{{ user.name }}</h1>
      </div>
    </div>
    <div class="row">
      <div class="col-6">
        <form @submit.prevent="sendForm">
          <div class="mb-3">
            <h5 class="mb-3">Вариации донатов</h5>
            <VueSlickCarousel class="proposed-options"
                              :arrows="false"
                              :variableWidth="true"
                              :infinite="false"
                              :focusOnSelect="true"
                              :slidesToShow="3.3"
                              :swipeToSlide="true"
                              @beforeChange="test">
              <vs-radio v-model="donate.sum" :val="100">
                <div class="proposed-options__item">
                  <span class="proposed-options__sum">100₽</span>
                  <span class="proposed-options__title">минимум</span>
                </div>
              </vs-radio>
              <vs-radio v-model="donate.sum" :val="666">
                <div class="proposed-options__item">
                  <span class="proposed-options__sum">666₽</span>
                  <span class="proposed-options__title">скример</span>
                </div>
              </vs-radio>
              <vs-radio v-model="donate.sum" :val="1000">
                <div class="proposed-options__item">
                  <span class="proposed-options__sum">1000₽</span>
                  <span class="proposed-options__title">стриптиз</span>
                </div>
              </vs-radio>
              <vs-radio v-model="donate.sum" :val="2000">
                <div class="proposed-options__item">
                  <span class="proposed-options__sum">2000₽</span>
                  <span class="proposed-options__title">пердеж</span>
                </div>
              </vs-radio>
              </VueSlickCarousel>
          </div>
          <div class="mb-4">
            <h5 class="mb-2">Ваше имя</h5>
            <vs-input border v-model="donate.donation_sender" placeholder="Диваныч">
            <template #icon>
              <i class='bx bx-user'></i>
            </template>
            </vs-input>
          </div>
          <div class="mb-4">
            <h5 class="mb-2">Сумма доната</h5>
            <vs-input border v-model="donate.sum" placeholder="100">
              <template #icon>
                ₽
              </template>
            </vs-input>
          </div>
          <div class="mb-4">
            <h5 class="mb-2">Текст сообщения</h5>
            <vs-input border v-model="donate.text" placeholder="Ты топчик!">
              <template #icon>
                <i class='bx bx-comment-detail'></i>
              </template>
            </vs-input>
          </div>
          <vs-button size="xl">
            Отправить
          </vs-button>
        </form>
      </div>
      <div class="col-5 offset-1">
        <h5>Цель сбора</h5>
      </div>
    </div>
  </div>
</template>

<script>
import VueSlickCarousel from 'vue-slick-carousel';
import 'vue-slick-carousel/dist/vue-slick-carousel.css';
import 'vue-slick-carousel/dist/vue-slick-carousel-theme.css';

let loading = '';

export default {
  name: 'Donate',
  components: {
    VueSlickCarousel,
  },
  data: () => ({
    user: {
      name: null,
    },
    donate: {
      text: 'Ты суперкласс!',
      donation_sender: 'Лолита',
      sum: 300,
    },
  }),
  mounted() {
    const self = this;
    self.$http.get(`users/${self.$route.params.user}`)
      .then((response) => {
        self.user = response.data;
      });
  },
  methods: {
    test(old, newe) {
      console.log(old, newe);
    },
    donateNotification(text = 'Счастья, здоровья!', border = 'success', title = 'Донат отправлен') {
      loading.close();
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
        });
    },
  },
};
</script>

<style scoped lang="scss">
.proposed-options::v-deep {
  font-weight: bold;
  .slick-list {
    padding: .5rem 0 1.5rem 1.2rem;
    .slick-track {
      display: flex;
      gap: 1rem;
    }
  }
  .vs-radio {
    display: none !important;

    &-content {
      &.active {
        .proposed-options__item {
          box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
          transform: scale(1.05);
        }
      }
    }

    &__label {
      margin: 0;

      .proposed-options {
        &__item {
          display: flex;
          flex-direction: column;
          border-radius: 10px;
          width: 150px;
          padding: 1rem;
          background: #9fcdff;
          cursor: pointer;
          transition: .3s;

          &:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
            transform: scale(1.05);
          }
        }

        &__sum {
          font-size: 1.5rem;
          line-height: 1.5rem;
        }
      }
    }
  }
}
</style>
