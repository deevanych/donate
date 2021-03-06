<template>
  <MediaWidget/>
</template>

<script>
import MediaWidget from '@/components/widgets/MediaWidgetComponent.vue';
import { get, getData } from '@/api/widgets';
import { donationsType } from '@/types/donations';
import { settingsType } from '@/types/settings';

export default {
  name: 'StatsWidgetLayout',
  components: {
    MediaWidget,
  },
  data() {
    return {
      donations: donationsType,
      settings: settingsType,
    };
  },
  mounted() {
    const widgetId = this.$route.params.id;
    get(widgetId).then((res) => {
      this.settings = res.data.settings;
    });
    getData(widgetId).then((res) => {
      this.donations = res.data;
    });
  },
};
</script>
