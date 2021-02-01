<template>
  <div>
    <DashboardPageTitle
      title="Виджеты"
      description="Виджеты статистики, уведомлений и прочее">
    </DashboardPageTitle>
    <InputSection
      v-for="widgetType in WIDGETS_TYPES"
      :key="widgetType.id"
      :title="widgetType.title"
      class="widget__section mb-5">
      <template v-if="widgetType.widgets.length != 0">
        <router-link v-for="widget in widgetType.widgets"
                     :key="widget.id"
                     :to="{name: 'widgets.show', params: {'id': widget.id}}">
          sadsa
          <a :href="widget.embed_link">анкор</a>
        </router-link>
      </template>
      <div v-else>
        Виджетов нет, создай один, быстро!
      </div>
    </InputSection>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';
import DashboardPageTitle from '@/components/DashboardPageTitle.vue';
import InputSection from '@/components/InputSection.vue';

let loading = '';

export default {
  name: 'WidgetsPage',
  components: {
    DashboardPageTitle,
    InputSection,
  },
  mounted() {
    loading = this.$vs.loading();
    this.$store.dispatch('GET_WIDGET_TYPES').finally(() => {
      loading.close();
    });
  },
  computed: {
    ...mapGetters(['WIDGETS_TYPES']),
  },
};
</script>

<style scoped lang="scss">
.widget__section {

}
</style>
