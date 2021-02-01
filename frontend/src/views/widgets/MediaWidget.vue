<template>
  <div v-if="showVideo" class="embed-responsive embed-responsive-16by9">
    <YoutubeVue class="embed-responsive-item"
                ref="youtube"
                :videoid="videoId"
                @ended="ended"
                @ready="playVideo"/>
  </div>
</template>

<script>
import { YoutubeVue } from 'youtube-vue';

export default {
  name: 'MediaWidget',
  data() {
    return {
      videoId: '',
      showVideo: false,
    };
  },
  components: {
    YoutubeVue,
  },
  computed: {
    player() {
      return this.$refs.youtube.player;
    },
  },
  methods: {
    ended() {
      this.showVideo = false;
    },
    async playVideo() {
      await this.player.playVideo();
    },
  },
  mounted() {
    const channel = this.$pusher.subscribe(`channel-${this.$route.query.signature}`);
    channel.bind('media.received', (media) => {
      this.videoId = this.$youtube.getIdFromUrl(media.uri);
      this.$nextTick(() => {
        this.showVideo = true;
      });
    });
  },
};
</script>

<style scoped>

</style>
