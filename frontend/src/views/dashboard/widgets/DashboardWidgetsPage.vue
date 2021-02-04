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
      v-for="widgetType in WIDGETS_TYPES"
      :key="widgetType.id"
      :title="widgetType.title"
      class="widget__section mb-5">
        <router-link v-for="widget in widgetType.widgets"
                     :key="widget.id"
                     :to="{name: 'widgets.show', params: {'id': widget.id}}">
          sadsa
          <a :href="widget.embed_link">анкор</a>
        </router-link>
      <vs-card class="widget__item" @click="showCreateWidgetPopup = true">
        <template #img>
          <h1><i class='bx bx-plus'></i></h1>
        </template>
      </vs-card>
    </InputSection>
    <vs-dialog v-model="showCreateWidgetPopup" full-screen class="widget__popup widget__popup-create">
      <div class="con-form row p-5">
        <div class="col-9">
          <StatsWidget
            :donations="donations"
            :type="newWidgetInstance.widget_view_type"
            :title="newWidgetInstance.title"
            :text_template="newWidgetInstance.text_template"
            :align="newWidgetInstance.align"
            :marquee-duration="newWidgetInstance.marqueeDuration"
            :test="true"
          />
        </div>
        <div class="col-3 widget__settings">
          <InputSection title="Настройки данных">
            <InputField title="Название виджета">
              <vs-input border v-model="newWidgetInstance.title" placeholder="необязательно" class="widget__title">
                <template #icon>
                  <i class='bx bx-tag-alt'></i>
                </template>
              </vs-input>
            </InputField>
            <InputField title="Тип статистики">
              <vs-select placeholder="Тип статистики" v-model="newWidgetInstance.widget_stats_type_id">
                <vs-option label="Топ донатеров" :value="1">
                  Топ донатеров
                </vs-option>
                <vs-option label="Топ донатов" :value="2">
                  Топ донатов
                </vs-option>
                <vs-option label="Последние донаты" :value="3">
                  Последние донаты
                </vs-option>
              </vs-select>
            </InputField>
            <InputField title="Период">
              <vs-select placeholder="Период выборки" v-model="newWidgetInstance.period">
                <vs-option label="Текущий день" value="current_day">
                  Текущий день
                </vs-option>
                <vs-option label="Текущая неделя" value="current_week">
                  Текущая неделя
                </vs-option>
                <vs-option label="Текущий месяц" value="current_month">
                  Текущий месяц
                </vs-option>
                <vs-option label="Текущий год" value="current_year">
                  Текущий год
                </vs-option>
                <vs-option label="Последний день" value="last_day">
                  Последний день
                </vs-option>
                <vs-option label="Последняя неделя" value="last_week">
                  Последняя неделя
                </vs-option>
                <vs-option label="Последний месяц" value="last_month">
                  Последний месяц
                </vs-option>
                <vs-option label="Последний год" value="last_year">
                  Последний год
                </vs-option>
                <vs-option label="Все время" value="all">
                  Все время
                </vs-option>
              </vs-select>
            </InputField>
            <InputField title="Количество элементов">
            <vs-input border v-model="newWidgetInstance.elements_count" placeholder="Количество">
              <template #icon>
                <i class='bx bx-abacus' ></i>
              </template>
            </vs-input>
          </InputField>
          </InputSection>
          <InputSection title="Формат данных">
            <InputField title="Тип отображения">
              <vs-select placeholder="Тип отображения" v-model="newWidgetInstance.widget_view_type">
                <vs-option label="Список" value="list">
                  Список
                </vs-option>
                <vs-option label="Бегущая строка" value="marquee">
                  Бегущая строка
                </vs-option>
                <vs-option label="Слайдер" value="slider">
                  Слайдер
                </vs-option>
              </vs-select>
            </InputField>
            <template v-if="newWidgetInstance.widget_view_type === 'list'">
              <InputField title="Выравнивание">
                <vs-button-group class="justify-content-start">
                  <vs-button border icon
                             :active="newWidgetInstance.align === 'left'"
                             @click="newWidgetInstance.align = 'left'">
                    <i class='bx bx-align-left'></i>
                  </vs-button>
                  <vs-button border icon
                             :active="newWidgetInstance.align === 'center'"
                             @click="newWidgetInstance.align = 'center'">
                    <i class='bx bx-align-middle'></i>
                  </vs-button>
                  <vs-button border icon
                             :active="newWidgetInstance.align === 'right'"
                             @click="newWidgetInstance.align = 'right'">
                    <i class='bx bx-align-right'></i>
                  </vs-button>
                </vs-button-group>
              </InputField>
            </template>
            <template v-if="newWidgetInstance.widget_view_type === 'marquee'">
              <InputField title="Скорость прокрутки">
                <RangeSlider
                  v-model="newWidgetInstance.marqueeDuration"
                  :min="0"
                />
              </InputField>
            </template>
            <template v-if="newWidgetInstance.widget_view_type === 'slider'">
              <InputField title="Выравнивание">
                <vs-button-group class="justify-content-start">
                  <vs-button border icon
                             :active="newWidgetInstance.align === 'left'"
                             @click="newWidgetInstance.align = 'left'">
                    <i class='bx bx-align-left'></i>
                  </vs-button>
                  <vs-button border icon
                             :active="newWidgetInstance.align === 'center'"
                             @click="newWidgetInstance.align = 'center'">
                    <i class='bx bx-align-middle'></i>
                  </vs-button>
                  <vs-button border icon
                             :active="newWidgetInstance.align === 'right'"
                             @click="newWidgetInstance.align = 'right'">
                    <i class='bx bx-align-right'></i>
                  </vs-button>
                </vs-button-group>
              </InputField>
            </template>
            <InputField title="Шаблон текста"
                      help-text="<div class='p-2 text-left'>
                      <b>Поддерживаемые переменные:</b>
                      <br/>
                      <b>{ sender }</b> - имя пользователя
                      <br/>
                      <b>{ sum }</b> - сумма доната
                      <br/>
                      <b>{ currency }</b> - валюта
                      <div>">
            <vs-input border placeholder="Шаблон текста" v-model="newWidgetInstance.text_template">
              <template #icon>
                <i class='bx bx-text' ></i>
              </template>
            </vs-input>
          </InputField>
          </InputSection>
        </div>
      </div>

    </vs-dialog>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';
import DashboardPageTitle from '@/components/DashboardPageTitle.vue';
import InputSection from '@/components/InputSection.vue';
import InputField from '@/components/InputField.vue';
import StatsWidget from '@/views/widgets/stats/StatsWidget.vue';
import RangeSlider from '@/components/@ui/RangeSlider.vue';

export default {
  name: 'WidgetsPage',
  data() {
    return {
      pageTitle: 'Виджеты',
      showCreateWidgetPopup: true,
      newWidgetInstance: {
        title: '',
        widget_stats_type_id: 1,
        widget_view_type: 'list',
        period: 'current_day',
        elements_count: 5,
        text_template: '{ sender } - { sum }',
        align: 'center',
        marqueeDuration: 10,
      },
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
    };
  },
  components: {
    DashboardPageTitle,
    InputSection,
    InputField,
    StatsWidget,
    RangeSlider,
  },
  mounted() {
    const loading = this.$vs.loading();
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
.vs-dialog-content::v-deep {
  .vs-dialog__content {
    height: 100%;
    position: relative;

    .con-form {
      height: 100%;
    }
  }
}

.widget__settings {
  height: 100%;
  overflow-x: hidden;
  overflow-y: auto;
}

.widget__item::v-deep {
  width: 200px;
  .vs-card__img {
    width: 100%;
    height: 100px;
  }
}
</style>
