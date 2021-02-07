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
      <div class="row">
        <div class="col-4" v-for="(widget, n) in widgetType[0].widgets" :key="widget.id">
          <vs-card class="widget__item" @click="showForm('stats', widget, n)">
            <template #title v-if="widget.settings.title.text">
              <h3>{{ widget.settings.title.text }}</h3>
            </template>
            <template #img>
              <div class="widget__background" :style="{background: widget.settings.title.background}"></div>
            </template>
            <template #text>
              <ClipboardCopyRow v-model="widget.embed_link"/>
            </template>
            <template #interactions>
              <vs-button danger icon>
                <i class='bx bx-x-circle'></i>
              </vs-button>
              <vs-button class="btn-chat" shadow primary>
                <i class='bx bx-copy mr-2'></i>
                <span class="span">
                копировать
              </span>
              </vs-button>
            </template>
          </vs-card>
        </div>
        <div class="col-4">
          <vs-card class="widget__item widget__add-item" @click="showForm('stats')">
            <template #img>
              <h1><i class='bx bx-plus'></i></h1>
            </template>
          </vs-card>
        </div>
      </div>
    </InputSection>
    <vs-dialog v-model="showCreateWidgetPopup.stats" full-screen class="widget__popup widget__popup-create">
      <StatsWidgetCreatingForm @widgetCreated="addWidget" @widgetUpdated="updateWidget" v-model="widget"/>
    </vs-dialog>
  </div>
</template>

<script>
import StatsWidgetCreatingForm from '@/components/widgets/StatsWidgetCreatingForm.vue';
import DashboardPageTitle from '@/components/DashboardPageTitle.vue';
import InputSection from '@/components/InputSection.vue';
import ClipboardCopyRow from '@/components/@ui/ClipboardCopyRow.vue';
import widgetsTypesApi from '@/api/widgetsTypes';

export default {
  name: 'WidgetsPage',
  components: {
    StatsWidgetCreatingForm,
    DashboardPageTitle,
    InputSection,
    ClipboardCopyRow,
  },
  data() {
    return {
      pageTitle: 'Виджеты',
      widgetsTypes: [],
      widget: null,
      widgetIndex: null,
      showCreateWidgetPopup: {
        media: false,
        stats: false,
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

<style scoped lang="scss">
.widget__item {
  margin-bottom: 2rem;
  .vs-card {
    height: 100%;
    min-height: 144px;
    display: flex;
  }
}

.widget__item.widget__add-item::v-deep {
  margin-bottom: 0;
  > .vs-card__img {
    height: 100%;
    display: flex;

    h1 {
      margin: auto;
      font-size: 4rem;
    }
  }
  .vs-card {
    height: 100%;
    min-height: 144px;
    display: flex;
  }
}

.vs-card-content::v-deep {
  .vs-card__interactions {
    position: relative;
  }
  .vs-card__img {
    justify-content: flex-start;
    margin: auto;
    .widget__background {
      position: absolute;
      width: 100%;
      height: 100%;
      opacity: .3;
    }
  }
  .vs-card__text {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;

    .vs-card__title {
      h3 {
        overflow: hidden;
        text-overflow: ellipsis;
      }
    }
  }
}

.vs-dialog-content::v-deep {
  .vs-dialog__content {
    height: 100%;
    position: relative;
  }
}
</style>
