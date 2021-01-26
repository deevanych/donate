<template>
  <div class="donation__wrapper position-absolute">
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
    localStorage.setItem('_token', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIyIiwianRpIjoiZWQ1MmEwM2Y0ZjNiMzMzMjUyMWMzMTc2OTM5ZGU2ZmJmNzBjOGY1OWEzYzA0NmU2MjcwMGJiNTcwYjk1NjZkZTM1OTRjNGViZWQyZDU0NDEiLCJpYXQiOiIxNjExNjE3NzQwLjA4MTA2NyIsIm5iZiI6IjE2MTE2MTc3NDAuMDgxMDc3IiwiZXhwIjoiMTY0MzE1Mzc0MC4wMTU4MzkiLCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.jGtm6HsOmYc3j_9r-X2fp-3MMeEM6e56yOjmXy_NLh9qgteENwAuORnBcqPP3UYuaumLz5NQiXxDtr3cw1RTw5408UrG5-aUnsB6G4xWPNKZ0l5EwDv2xuW91N1n0YpkkLocqvmLLG2bUhhFtnoctAhMkprLYkPmtMFQ6pLTAWFoRXZ-17dO1UXJ9b_IBYwoFtwixJbwoJvYUWVvKLwj-1rBypSESKw5cdAg0IwzX5-JIVVa45IH4m6EGQkPzMN3SFyC9hv6THp8HmfCI41PhnVm1iuJeV-MMXZe7qLdWsy5AAI7fDn2YHr6zSYYt3P4xJev87hRmaxu3afT6ko_csS05SO09j-ZFoTUCz3HDk-dx4pg6BllkL1ZVsIVMXGkrUDPBV3YWlDpi8EEIJBoKnQVQAwbVtljGUs7cBBKFhNoU3cT-dIIdU3K-jU8yubZYpe7cLlza3WpGqPTUjuQMCANRa1RFrA0JJfRujPvlRsvYFkL0JYgBUtGYYjRRaBa1SrrYV_1hopanPr7YBjk427koGtaXAaeBwOaIolL7M_lI_rjRJziWem8eMpJffNvZHNbZ5HVk3HDRmWvfHvwpOKOLgD7vtXnC8KXDdNSNFpTZbDI74KrGH-JarXXwgKCE1G0YIrLQQ8eknyCTEmyUaDn1SWAqwpzfcTT4j0-cgg');
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
