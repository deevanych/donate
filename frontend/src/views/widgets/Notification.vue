<template>
  <div class="donation__wrapper">
    <div class="donation__item" v-if="showDonation">
      <h1>{{ donation.donation_sender }} - {{ donation.sum }}₽</h1>
      <h2>{{ donation.text }}</h2>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Notification',
  data: () => ({
    donation: {
      text: null,
      donation_sender: null,
      sum: null,
    },
    showDonation: false,
  }),
  mounted() {
    const self = this;
    self.$http.get(`users/${self.$route.params.user}`)
      .then((response) => {
        const channel = this.$pusher.subscribe(`channel-${response.data.id}`);

        channel.bind('donation.created', ({ donation }) => {
          self.showDonation = true;
          self.donation = donation;
          if (donation.speech_uri !== null) {
            const speech = new Audio(donation.speech_uri);
            speech.addEventListener('canplay', () => {
              speech.play();
            });
            speech.addEventListener('ended', () => {
              setTimeout(() => {
                self.showDonation = false;
              }, 3000);
            });
          } else if (donation.text !== null) {
            speechSynthesis.speak(new SpeechSynthesisUtterance(donation.text));
            setTimeout(() => {
              self.showDonation = false;
            }, 3000);
          } else {
            setTimeout(() => {
              self.showDonation = false;
            }, 3000);
          }
        });
      });
  },
};
</script>

<style scoped lang="scss">
.donation {
  &__wrapper {

  }

  &__item {

  }
}
</style>
