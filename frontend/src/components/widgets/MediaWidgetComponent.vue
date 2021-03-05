<template>
  <div v-if="showVideo" class="embed-responsive embed-responsive-16by9">
    <YoutubeVue ref="youtube"
                :videoid="videoId"
                class="embed-responsive-item"
                :player-vars="{ autoplay: 1 }"
                @ready="play"
                @ended="showVideo = false"/>
  </div>
</template>

<script>
import { YoutubeVue } from 'youtube-vue';

export default {
  name: 'MediaWidget',
  props: {
    maxVideoLength: {
      type: Number,
      default: 300,
    },
  },
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
    play() {
      this.player.play();
    },
  },
  mounted() {
    const channel = this.$pusher.subscribe(`channel-${this.$route.params.id}`);
    channel.bind('media.received', (media) => {
      this.videoId = this.$youtube.getIdFromUrl(media.uri);
      // todo
      this.$http(`https://www.googleapis.com/youtube/v3/videos?part=statistics,snippet,contentDetails&id=${this.videoId}&key=AIzaSyC2OsmWwJxc4UCY2lQoPxPW68dd9bO-nzA&part=status`).then(() => {
        this.$nextTick(() => {
          this.showVideo = true;
        });
      });
    });
  },
};
</script>

<style scoped>

</style>
