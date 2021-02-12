<template>
  <div>
    <VueHeadFul
      :title="pageTitle"
    />
    <DashboardPageTitle
      :title="pageTitle"
      description="Виджеты статистики, уведомлений и прочее">
    </DashboardPageTitle>
    <InputSection
      v-for="widgetType in widgetsTypes"
      :key="widgetType[0].id"
      :title="widgetType[0].title">
      <div class="row widget__list">
        <WidgetItem v-for="(widget, index) in widgetType[0].widgets"
                    :key="widget.id"
                    :widget="widget"
                    :widgetType="widgetType[0].slug"
                    @click.native="showForm('stats', widget, index)"/>
        <div class="col-4" v-if="widgetType[0].slug !== 'media'">
          <vs-card class="widget__item widget__add-item" @click="showForm(widgetType[0].slug)">
            <template #img>
              <h1><i class='bx bx-plus'></i></h1>
            </template>
          </vs-card>
        </div>
      </div>
    </InputSection>
    <vs-dialog v-model="showCreateWidgetPopup.stats" class="widget__popup widget__popup-create" full-screen>
      <StatsWidgetCreatingForm v-model="widget" @widgetCreated="addWidget" @widgetUpdated="updateWidget"/>
    </vs-dialog>
  </div>
</template>

<script>
import StatsWidgetCreatingForm from '@/components/widgets/StatsWidgetCreatingForm.vue';
import DashboardPageTitle from '@/components/DashboardPageTitle.vue';
import InputSection from '@/components/InputSection.vue';
import widgetsTypesApi from '@/api/widgetsTypes';
import WidgetItem from '@/components/@ui/WidgetItem.vue';

export default {
  name: 'WidgetsPage',
  components: {
    StatsWidgetCreatingForm,
    DashboardPageTitle,
    InputSection,
    WidgetItem,
  },
  data() {
    return {
      pageTitle: 'Виджеты',
      widgetsTypes: [],
      widget: null,
      widgetIndex: null,
      showCreateWidgetPopup: {
        media: false,
        stats: true,
        notifications: false,
        goals: false,
      },
    };
  },
  methods: {
    addWidget(data) {
      this.showCreateWidgetPopup[data.type] = false;
      this.$set(this.widgetsTypes[data.type][0].widgets, this.widgetsTypes[data.type][0].widgets.length, data.widget);
    },
    updateWidget(data) {
      this.showCreateWidgetPopup[data.type] = false;
      this.$set(this.widgetsTypes[data.type][0].widgets, this.widgetIndex, data.widget);
    },
    showForm(type, widget = null, index = null) {
      this.widget = widget;
      this.widgetIndex = index;
      this.showCreateWidgetPopup[type] = true;
    },
  },
  mounted() {
    const loading = this.$vs.loading();
    widgetsTypesApi.getList().then((res) => {
      this.widgetsTypes = res.data;
    })
      .finally(() => {
        loading.close();
      });
  },
};
</script>

<style lang="scss" scoped>
.widget__list {
  row-gap: 2rem;
}

.vs-dialog-content::v-deep {
  .vs-dialog__content {
    height: 100%;
    position: relative;
  }
}

.widget__add-item::v-deep {
  margin-bottom: 0;

  .vs-card {
    height: 100%;
    min-height: 144px;
    display: flex;
  }

  .vs-card__img {
    margin: auto;

    h1 {
      margin: auto;
      font-size: 4rem;
    }
  }
}
</style>
