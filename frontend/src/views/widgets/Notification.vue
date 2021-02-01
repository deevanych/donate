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
    localStorage.setItem('_token', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIyIiwianRpIjoiZDY2Yzk5MmMxMjUxNDY1ZmIyOGZkODg0MTI0YWUzMDQ4YjVhOTQ4ZmVlYzg4NmE0NjE2NmI1ZWI1ZmI1ZTUwNGVhZDViM2M2NmE5OGUzYTIiLCJpYXQiOiIxNjEyMTE3ODMxLjkxNjYxMCIsIm5iZiI6IjE2MTIxMTc4MzEuOTE2NjI0IiwiZXhwIjoiMTY0MzY1MzgzMS42NjM0OTIiLCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.nhxf5e1IQjMAQO610SNuH-LVgi_F0GOpdcX69s0okTYyBQ0EadqP8q8y0mN-9iJux-f8pM-o_ry5hSLbXRrEj1Pfrn3bVcKoCNrZrn8bNIwig8DgBABaLFORdM_rxkt-5cBRKmB7D-lRd1vlN8cwwp476MMmRVfmNwwI0xFJwlrYKiVP1TYc5rmXJxsMmqs1RqUG1nVihIMq5dLAaSG4CXj8oMYEkVqd9YzSSJKKAatCIyEDHeowA57DoRRyLyTqUiE_2aUrFk-t885yfQkysKFdkI2x_ifC7baxJRgdJCucSqCZe8wC_XTyh1Ld8-My7fjw-erm5l71x_97mmZjFNxZM84Yw1Eg91IXlx7eu11ijPvyBNNYn2IqU6wNbCdLdRNb9rkWbBaibGCsUVajSrX5uLJqzj3ler98CIWtrnV8sStXVVciu37X0_5lqKxrwg32sintBL0Iom2z18mmNxL7sRnGlBHOxsie7lHQHJ_08Kg13G4TTw0W0ELOj1gvkvH5wNBYfEFj1XqhdvlxAkPOmHj9hzohPS9DUqziJlXOWY8i4wvLufg9oJtNH2rp3pYP0Io9PrSLFXCN6rsBwWEIKG69OxEyvjgPfj875nOXc4w2Ff1C00l_Eszs-XXDmhg1ik6471194eBc6_v-riE15_CKqM-ByMQjC4kTo2E');
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
