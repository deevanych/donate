<template>
  <MediaWidget/>
</template>

<script>
import MediaWidget from '@/views/widgets/MediaWidget.vue';
import widgets from '@/api/widgets';

export default {
  name: 'StatsWidgetLayout',
  components: {
    MediaWidget,
  },
  data() {
    return {
      donations: [
        {
          id: 1,
          donation_sender: 'Тимати',
          sum: 403,
        },
        {
          id: 2,
          donation_sender: 'Джежай',
          sum: 32,
        },
        {
          id: 3,
          donation_sender: 'Лещ',
          sum: 143,
        },
        {
          id: 4,
          donation_sender: 'Пурда',
          sum: 3,
        },
      ],
      settings: [],
    };
  },
  mounted() {
    const widgetId = this.$route.params.id;
    widgets.get(widgetId).then((res) => {
      this.settings = res.data.settings;
    });
    widgets.getData(widgetId).then((res) => {
      this.donations = res.data;
    });
  },
};
</script>

<style scoped>

</style>
