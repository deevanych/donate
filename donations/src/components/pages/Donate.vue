<template>
  <div class="container">
    <div class="row mb-5">
      <div class="col">
        <h1>{{ user.name }}</h1>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <form @submit.prevent="sendForm">
          <vs-input v-model="donate.donation_sender"
                    label="Ваше имя" placeholder="Диваныч" class="mb-5"/>
          <vs-input v-model="donate.sum" label="Сумма" placeholder="300" class="mb-5"/>
          <div class="position-relative">
            <label class="vs-input__label vs-input__label--label">Текст сообщения</label>
            <textarea v-model="donate.text" placeholder="Привет, ты топчик!"></textarea>
          </div>
          <vs-button>
            Отправить
          </vs-button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
let loading = '';
export default {
  name: 'Donate',
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
</style>
