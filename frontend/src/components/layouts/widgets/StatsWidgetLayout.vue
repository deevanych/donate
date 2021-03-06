<template>
  <StatsWidget
    v-if="settings.length !== 0"
    :donations="donations"
    :widget="settings"
  />
</template>

<script>
import StatsWidget from '@/components/widgets/StatsWidgetComponent.vue';
import { get, getData } from '@/api/widgets';
import { donationsType } from '@/types/donations';
import { statsWidgetType } from '@/types/statsWidgetType';

export default {
  name: 'StatsWidgetLayout',
  components: {
    StatsWidget,
  },
  data() {
    return {
      donations: donationsType,
      settings: statsWidgetType,
    };
  },
  mounted() {
    const widgetId = this.$route.params.id;
    get(widgetId).then(({ data }) => {
      this.settings = data.settings;
    });
    getData(widgetId).then(({ data }) => {
      this.donations = data;
    });
  },
};
</script>
