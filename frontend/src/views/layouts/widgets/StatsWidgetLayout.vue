<template>
  <StatsWidget
    v-if="settings.length !== 0"
    :donations="donations"
    :widget="settings"
  />
</template>

<script>
import StatsWidget from '@/views/widgets/StatsWidget.vue';
import widgets from '@/api/widgets';

export default {
  name: 'StatsWidgetLayout',
  components: {
    StatsWidget,
  },
  data() {
    return {
      donations: [
        {
          id: 1,
          sender: 'Тимати',
          sum: 403,
        },
        {
          id: 2,
          sender: 'Джежай',
          sum: 32,
        },
        {
          id: 3,
          sender: 'Лещ',
          sum: 143,
        },
        {
          id: 4,
          sender: 'Пурда',
          sum: 3,
        },
      ],
      settings: [],
    };
  },
  beforeCreate() {
    const widgetId = this.$route.params.id;
    widgets.get(widgetId).then((res) => {
      this.settings = res.data.settings;
    });
  },
};
</script>

<style scoped>

</style>
