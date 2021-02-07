<template>
  <div class="con-form row p-5">
    <div class="col-9">
      <StatsWidget
        :donations="donations"
        :widget="widget.settings"
        :test="true"
      />
    </div>
    <div class="col-3 widget__settings">
      <perfect-scrollbar :options="{suppressScrollX: true}">
        <InputSection title="Настройки данных">
          <InputField title="Название виджета">
            <vs-input border v-model="widget.settings.title.text" placeholder="необязательно"
                      class="widget__title">
              <template #icon>
                <i class='bx bx-tag-alt'></i>
              </template>
            </vs-input>
          </InputField>
          <InputField title="Тип статистики">
            <vs-select placeholder="Тип статистики" v-model="widget.settings.stats_type">
              <vs-option label="Топ донатеров" value="senders_top">
                Топ донатеров
              </vs-option>
              <vs-option label="Топ донатов" value="donations_top">
                Топ донатов
              </vs-option>
              <vs-option label="Последние донаты" value="donations_latest">
                Последние донаты
              </vs-option>
            </vs-select>
          </InputField>
          <InputField title="Период">
            <vs-select placeholder="Период выборки" v-model="widget.settings.period">
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
            <vs-input border v-model="widget.settings.elements_count" placeholder="Количество">
              <template #icon>
                <i class='bx bx-abacus'></i>
              </template>
            </vs-input>
          </InputField>
        </InputSection>
        <InputSection title="Формат данных">
          <InputField title="Тип отображения">
            <vs-select placeholder="Тип отображения" v-model="widget.settings.widget_view_type">
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
          <InputField title="Выравнивание">
            <vs-button-group class="justify-content-start">
              <vs-button border icon
                         :active="widget.settings.align === 'left'"
                         @click="widget.settings.align = 'left'">
                <i class='bx bx-align-left'></i>
              </vs-button>
              <vs-button border icon
                         :active="widget.settings.align === 'center'"
                         @click="widget.settings.align = 'center'">
                <i class='bx bx-align-middle'></i>
              </vs-button>
              <vs-button border icon
                         :active="widget.settings.align === 'right'"
                         @click="widget.settings.align = 'right'">
                <i class='bx bx-align-right'></i>
              </vs-button>
            </vs-button-group>
          </InputField>
          <template v-if="widget.settings.widget_view_type === 'marquee'">
            <InputField title="Скорость прокрутки">
              <RangeSlider
                v-model="widget.settings.marquee_duration"
                :min="0"
                :max="100"
                tooltip="hover"
              />
            </InputField>
          </template>
          <template v-if="widget.settings.widget_view_type === 'slider'">
            <InputField title="Длительность слайда">
              <RangeSlider
                v-model="widget.settings.slider_speed"
                :min="0"
                :step="1000"
                :max="10000"
                :formatter="formattedValue(widget.settings.slider_speed, 'сек', 1000)"
                tooltip="hover"
              />
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
            <vs-input border placeholder="Шаблон текста" v-model="widget.settings.text_template">
              <template #icon>
                <i class='bx bx-text'></i>
              </template>
            </vs-input>
          </InputField>
        </InputSection>
        <InputSection v-if="widget.settings.title.text" title="Заголовок">
          <InputField title="Шрифт">
            <GoogleFontPicker v-model="widget.settings.title['font-family']"/>
          </InputField>
          <InputField title="Стиль">
            <vs-button-group class="justify-content-start">
              <vs-button border icon
                         :active="widget.settings.title['font-style'] === 'italic'"
                         @click="toggleStyle('title', 'font-style', ['italic', 'normal'])">
                <i class='bx bx-italic'></i>
              </vs-button>
              <vs-button border icon
                         :active="widget.settings.title['font-weight'] === 'bold'"
                         @click="toggleStyle('title', 'font-weight', ['normal', 'bold'])">
                <i class='bx bx-bold'></i>
              </vs-button>
              <vs-button border icon
                         :active="widget.settings.title['text-decoration'] === 'underline'"
                         @click="toggleStyle('title', 'text-decoration', ['none', 'underline'])">
                <i class='bx bx-underline'></i>
              </vs-button>
              <vs-button border icon
                         :active="widget.settings.title['text-decoration'] === 'line-through'"
                         @click="toggleStyle('title', 'text-decoration', ['none', 'line-through'])">
                <i class='bx bx-strikethrough'></i>
              </vs-button>
            </vs-button-group>
          </InputField>
          <InputField title="Цвет">
            <ColorPicker v-model="widget.settings.title.color"/>
          </InputField>
          <InputField title="Размер шрифта">
            <RangeSlider v-model="widget.settings.title['font-size']" :min="16" :max="70" tooltip="hover"/>
          </InputField>
          <InputField title="Цвет обводки">
            <ColorPicker v-model="widget.settings.title['-webkit-text-stroke-color']"/>
          </InputField>
          <InputField title="Ширина обводки">
            <RangeSlider v-model="widget.settings.title['-webkit-text-stroke-width']" :min="0" :max="10"
                         tooltip="hover"/>
          </InputField>
          <InputField title="Цвет фона">
            <ColorPicker v-model="widget.settings.title.background"/>
          </InputField>
          <InputField title="Отступ">
            <RangeSlider v-model="widget.settings.title.padding"
                         :min="0"
                         :max="30"
                         tooltip="hover"
                         :formatter="formattedValue(widget.settings.title.padding, 'пикс')"
            />
          </InputField>
          <InputField title="Закругление">
            <RangeSlider v-model="widget.settings.title['border-radius']"
                         :min="0"
                         :max="50"
                         tooltip="hover"
                         :formatter="formattedValue(widget.settings.title['border-radius'], 'пикс')"
            />
          </InputField>
          <InputField title="Смещение">
            <RangeSlider v-model="widget.settings.title.translate.x"
                         :min="-100"
                         :max="100"
                         tooltip="hover"
                         :formatter="formattedValue(widget.settings.title.translate.x, 'пикс')"
            />
            <RangeSlider v-model="widget.settings.title.translate.y"
                         :min="-100"
                         :max="100"
                         tooltip="hover"
                         :formatter="formattedValue(widget.settings.title.translate.y, 'пикс')"
            />
          </InputField>
        </InputSection>
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
import ColorPicker from '@/components/@ui/ColorPicker.vue';
import GoogleFontPicker from '@/components/@ui/GoogleFontPicker.vue';
import InputField from '@/components/InputField.vue';
import InputSection from '@/components/InputSection.vue';
import widgets from '@/api/widgets';

export default {
  name: 'StatsWidgetCreatingForm',
  components: {
    StatsWidget,
    RangeSlider,
    ColorPicker,
    GoogleFontPicker,
    InputField,
    InputSection,
  },
  data() {
    return {
      widget: {
        widget_type_id: 4,
        settings: {
          widget_view_type: 'marquee',
          stats_type: 'donations_top',
          period: 'current_day',
          elements_count: 5,
          text_template: '{ sender } - { sum }',
          align: 'left',
          marquee_duration: 10,
          slider_speed: 2000,
          title: {
            text: 'ПУППЕЙ',
            color: '#FFFFFF',
            'font-family': 'Google Sans',
            background: '#FF3C3CFF',
            'border-radius': 0,
            padding: 0,
            'font-size': 70,
            '-webkit-text-stroke-color': 'transparent',
            '-webkit-text-stroke-width': 0,
            translate: {
              x: 0,
              y: 0,
            },
            'font-style': 'italic',
            'font-weight': 'bold',
            'text-decoration': 'none',
          },
        },
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
  methods: {
    sendForm() {
      const loading = this.$vs.loading();
      widgets.create(this.widget).then((res) => {
        console.log(res);
      }).finally(() => {
        loading.close();
      });
    },
    formattedValue(value, property = null, step = 1) {
      return `${value / step} ${property}`;
    },
    toggleStyle(property, style, values) {
      this.widget.settings[property][style] = (this.widget.settings[property][style] === values[0] ? values[1] : values[0]);
    },
  },
};
</script>

<style scoped lang="scss">
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
