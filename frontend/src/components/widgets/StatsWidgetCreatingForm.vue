<template>
  <div class="con-form row p-5">
    <div class="col-8">
      <StatsWidget
        :donations="donations"
        :test="true"
        :widget="widget.settings"
      />
    </div>
    <div class="col-4 widget__settings">
      <perfect-scrollbar :options="{suppressScrollX: true}">
        <InputSection title="Настройки данных">
          <InputField title="Название виджета">
            <div class="col">
            <vs-input v-model="widget.settings.title.text" border class="widget__title"
                      placeholder="необязательно">
              <template #icon>
                <i class='bx bx-tag-alt'></i>
              </template>
            </vs-input>
            </div>
          </InputField>
          <InputField title="Тип статистики">
            <div class="col">
            <vs-select v-model="widget.settings.stats_type" placeholder="Тип статистики">
              <vs-option label="Топ донатеров" value="donators">
                Топ донатеров
              </vs-option>
              <vs-option label="Топ донатов" value="donations">
                Топ донатов
              </vs-option>
              <vs-option label="Последние донаты" value="latest">
                Последние донаты
              </vs-option>
            </vs-select>
          </div>
          </InputField>
          <InputField title="Период">
            <div class="col">
            <vs-select v-model="widget.settings.period" placeholder="Период выборки">
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
              <vs-option label="Все время" value="all_time">
                Все время
              </vs-option>
            </vs-select>
          </div>
          </InputField>
          <InputField title="Количество элементов">
            <div class="col">
            <vs-input v-model="widget.settings.elements_count" border placeholder="Количество">
              <template #icon>
                <i class='bx bx-abacus'></i>
              </template>
            </vs-input>
          </div>
          </InputField>
        </InputSection>
        <InputSection title="Формат данных">
          <InputField title="Тип отображения">
            <div class="col">
            <vs-select v-model="widget.settings.widget_view_type" placeholder="Тип отображения">
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
          </div>
          </InputField>
          <InputField title="Выравнивание">
            <div class="col">
            <vs-button-group class="justify-content-start">
              <vs-button :active="widget.settings.align === 'left'" border
                         icon
                         @click="widget.settings.align = 'left'">
                <i class='bx bx-align-left'></i>
              </vs-button>
              <vs-button :active="widget.settings.align === 'center'" border
                         icon
                         @click="widget.settings.align = 'center'">
                <i class='bx bx-align-middle'></i>
              </vs-button>
              <vs-button :active="widget.settings.align === 'right'" border
                         icon
                         @click="widget.settings.align = 'right'">
                <i class='bx bx-align-right'></i>
              </vs-button>
            </vs-button-group>
          </div>
          </InputField>
          <template v-if="widget.settings.widget_view_type === 'marquee'">
            <InputField title="Скорость прокрутки">
              <div class="col">
              <RangeSlider
                v-model="widget.settings.marquee_duration"
                :max="100"
                :min="0"
                tooltip="hover"
              />
            </div>
          </InputField>
          </template>
          <template v-if="widget.settings.widget_view_type === 'slider'">
            <InputField title="Длительность слайда">
              <div class="col">
              <RangeSlider
                v-model="widget.settings.slider_speed"
                :formatter="formattedValue(widget.settings.slider_speed, 'сек', 1000)"
                :max="10000"
                :min="0"
                :step="1000"
                tooltip="hover"
              />
            </div>
          </InputField>
          </template>
          <InputField help-text="<div class='p-2 text-left'>
                      <b>Поддерживаемые переменные:</b>
                      <br/>
                      <b>{ donation_sender }</b> - имя пользователя
                      <br/>
                      <b>{ sum }</b> - сумма доната
                      <br/>
                      <b>{ currency }</b> - валюта
                      <div>"
                      title="Шаблон текста">
            <div class="col">
            <vs-input v-model="widget.settings.text_template" border placeholder="Шаблон текста">
              <template #icon>
                <i class='bx bx-text'></i>
              </template>
            </vs-input>
            </div>
          </InputField>
        </InputSection>
        <AppearanceBlock v-bind:block="widget.settings.title"/>
        <vs-button size="xl" @click="sendForm">
          Сохранить
        </vs-button>
      </perfect-scrollbar>
    </div>
  </div>
</template>

<script>
import StatsWidget from '@/views/widgets/StatsWidget.vue';
import RangeSlider from 'vue-range-component-fixed';
import InputField from '@/components/InputField.vue';
import InputSection from '@/components/InputSection.vue';
import AppearanceBlock from '@/components/widgets/AppearanceBlock.vue';
import widgets from '@/api/widgets';

export default {
  name: 'StatsWidgetCreatingForm',
  components: {
    StatsWidget,
    RangeSlider,
    InputField,
    InputSection,
    AppearanceBlock,
  },
  props: {
    value: {
      type: Object,
      default: null,
    },
  },
  data() {
    return {
      widget: {
        widget_type_id: 4,
        settings: {
          widget_view_type: 'marquee',
          stats_type: 'donators',
          period: 'current_day',
          elements_count: 5,
          text_template: '{ donation_sender } - { sum }',
          align: 'left',
          marquee_duration: 10,
          slider_speed: 2000,
          title: {
            // background
            backgroundEnabled: false,
            'border-radius': 0,
            padding: 0,
            background: '{"angle":0,"stops":[["#0359b5",0],["#f6ce01",1]]}',

            // shadow
            shadowEnabled: false,
            shadowColor: '#000000',
            shadowBlur: 2,
            shadowPosition: {
              x: 2,
              y: -2,
            },

            // stroke
            strokeEnabled: false,
            stroke: '{"angle":0,"stops":[["#0359b5",0],["#f6ce01",1]]}',

            // text
            text: 'Заголовок',
            'font-size': '24',
            'font-family': 'Google Sans',
            color: '{"angle":0,"stops":[["#0359b5",0],["#f6ce01",1]]}',
            'font-style': 'normal',
            'font-weight': 'normal',
            'text-decoration': 'none',

            // position
            w: 200,
            h: 100,
            x: 100,
            y: 10,
            angle: 0,
          },
        },
      },
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
    };
  },
  mounted() {
    if (this.value) {
      const loading = this.$vs.loading();
      widgets.get(this.value.uuid).then((res) => {
        this.widget = res.data;
      })
        .finally(() => {
          loading.close();
        });
    }
  },
  methods: {
    sendForm() {
      const loading = this.$vs.loading();
      const method = (this.value ? widgets.update(this.value.uuid, this.widget) : widgets.create(this.widget));
      const event = (this.value ? 'widgetUpdated' : 'widgetCreated');
      method.then((res) => {
        this.$copyText(res.data.widget.embed_link);
        this.$vs.notification({
          position: 'top-right',
          border: 'success',
          title: res.data.message,
          text: 'Ссылка на виджет скопирована',
        });
        this.$emit(event, { type: 'stats', widget: res.data.widget });
      }).finally(() => {
        loading.close();
      });
    },
    formattedValue(value, property = null, step = 1) {
      return `${value / step} ${property}`;
    },
    toggleStyle(property, style, values) {
      this.widget.settings[property][style] = (this.widget.settings[property][style] === values[0] ? values[1] : values[0]);
    }
    ,
  },
};
</script>

<style lang="scss" scoped>
.con-form {
  height: 100%;
}

.widget__settings {
  height: 100%;

  .ps {
    height: 100%;
    width: 100%;
    padding-right: 15px;
  }
}
</style>
