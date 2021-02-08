<template>
  <div class="col-4">
    <vs-card class="widget__item">
      <template v-if="widget.settings.title.text" #title>
        <h3>{{ widget.settings.title.text }}</h3>
      </template>
      <template #img>
        <div :style="{background: widget.settings.title.background}" class="widget__background"></div>
      </template>
      <template #text>
        <ClipboardCopyRow v-model="widget.embed_link"/>
      </template>
      <template #interactions>
        <vs-button danger icon @click.stop="(deleted ? restoreWidget(widget.uuid) : deleteWidget(widget.uuid))">
          <lottie :options="defaultOptions"
                  class="lottie__delete"
                  @animCreated="handleAnimation"/>
        </vs-button>
        <vs-button class="btn-chat" primary shadow>
          <i class='bx bx-copy mr-2'></i>
          <span class="span">
                копировать
              </span>
        </vs-button>
      </template>
    </vs-card>
  </div>
</template>

<script>
import ClipboardCopyRow from '@/components/@ui/ClipboardCopyRow.vue';
import Lottie from 'vue-lottie';
import * as animationData from '@/assets/lottie/delete.json';
import widgets from '@/api/widgets';

export default {
  name: 'WidgetItem',
  props: {
    widget: {
      type: Object,
      required: true,
    },
  },
  components: {
    ClipboardCopyRow,
    Lottie,
  },
  data() {
    return {
      deleted: false,
      defaultOptions: {
        autoplay: false,
        animationData: animationData.default,
        renderer: 'canvas',
        loop: false,
      },
    };
  },
  methods: {
    handleAnimation(anim) {
      this.anim = anim;
      // this.anim.goToAndStop(0);
    },
    deleteWidget(widgetId) {
      const loading = this.$vs.loading();
      widgets.delete(widgetId).then(() => {
        this.deleted = true;
        this.anim.playSegments([0, 12], true);
        this.$vs.notification({
          position: 'top-right',
          border: 'success',
          title: 'Виджет удален',
          text: 'Он пропадет из списка после обновления страницы',
        });
      })
        .finally(() => {
          loading.close();
        });
    },
    restoreWidget(widgetId) {
      const loading = this.$vs.loading();
      widgets.restore(widgetId).then((res) => {
        this.deleted = false;
        this.anim.playSegments([12, 0], true);
        this.$copyText(res.data.widget.embed_link);
        this.$vs.notification({
          position: 'top-right',
          border: 'success',
          title: 'Виджет восстановлен',
          text: 'Ссылка на виджет скопирована',
        });
      })
        .finally(() => {
          loading.close();
        });
    },
  },
};
</script>

<style lang="scss" scoped>
.lottie__delete {
  display: flex;
  height: 1rem !important;
  width: 1rem !important;

  &::v-deep {
    svg {
      margin: auto;
    }

    * {
      color: #FFF;
      fill: #FFF;
      stroke: #FFF;
    }
  }
}

.widget__item {
  margin-bottom: 3rem;

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

</style>
