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
            <vs-input v-model="widget.settings.title.text" border class="widget__title"
                      placeholder="необязательно">
              <template #icon>
                <i class='bx bx-tag-alt'></i>
              </template>
            </vs-input>
          </InputField>
          <InputField title="Тип статистики">
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
          </InputField>
          <InputField title="Период">
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
          </InputField>
          <InputField title="Количество элементов">
            <vs-input v-model="widget.settings.elements_count" border placeholder="Количество">
              <template #icon>
                <i class='bx bx-abacus'></i>
              </template>
            </vs-input>
          </InputField>
        </InputSection>
        <InputSection title="Формат данных">
          <InputField title="Тип отображения">
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
          </InputField>
          <InputField title="Выравнивание">
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
          </InputField>
          <template v-if="widget.settings.widget_view_type === 'marquee'">
            <InputField title="Скорость прокрутки">
              <RangeSlider
                v-model="widget.settings.marquee_duration"
                :max="100"
                :min="0"
                tooltip="hover"
              />
            </InputField>
          </template>
          <template v-if="widget.settings.widget_view_type === 'slider'">
            <InputField title="Длительность слайда">
              <RangeSlider
                v-model="widget.settings.slider_speed"
                :formatter="formattedValue(widget.settings.slider_speed, 'сек', 1000)"
                :max="10000"
                :min="0"
                :step="1000"
                tooltip="hover"
              />
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
            <vs-input v-model="widget.settings.text_template" border placeholder="Шаблон текста">
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
              <vs-button :active="widget.settings.title['font-style'] === 'italic'" border
                         icon
                         @click="toggleStyle('title', 'font-style', ['italic', 'normal'])">
                <i class='bx bx-italic'></i>
              </vs-button>
              <vs-button :active="widget.settings.title['font-weight'] === 'bold'" border
                         icon
                         @click="toggleStyle('title', 'font-weight', ['normal', 'bold'])">
                <i class='bx bx-bold'></i>
              </vs-button>
              <vs-button :active="widget.settings.title['text-decoration'] === 'underline'" border
                         icon
                         @click="toggleStyle('title', 'text-decoration', ['none', 'underline'])">
                <i class='bx bx-underline'></i>
              </vs-button>
              <vs-button :active="widget.settings.title['text-decoration'] === 'line-through'" border
                         icon
                         @click="toggleStyle('title', 'text-decoration', ['none', 'line-through'])">
                <i class='bx bx-strikethrough'></i>
              </vs-button>
            </vs-button-group>
          </InputField>
          <InputField title="Цвет">
            <ColorPicker v-model="widget.settings.title.color"/>
          </InputField>
          <InputField title="Размер шрифта">
            <RangeSlider v-model="widget.settings.title['font-size']" :max="70" :min="16" tooltip="hover"/>
          </InputField>
          <InputField title="Цвет обводки">
            <ColorPicker v-model="widget.settings.title['-webkit-text-stroke-color']"/>
          </InputField>
          <InputField title="Ширина обводки">
            <RangeSlider v-model="widget.settings.title['-webkit-text-stroke-width']" :max="10" :min="0"
                         tooltip="hover"/>
          </InputField>
          <InputField title="Цвет фона">
            <ColorPicker v-model="widget.settings.title.background"/>
          </InputField>
          <InputField title="Отступ">
            <RangeSlider v-model="widget.settings.title.padding"
                         :formatter="formattedValue(widget.settings.title.padding, 'пикс')"
                         :max="30"
                         :min="0"
                         tooltip="hover"
            />
          </InputField>
          <InputField title="Закругление">
            <RangeSlider v-model="widget.settings.title['border-radius']"
                         :formatter="formattedValue(widget.settings.title['border-radius'], 'пикс')"
                         :max="50"
                         :min="0"
                         tooltip="hover"
            />
          </InputField>
          <InputField title="Смещение">
            <RangeSlider v-model="widget.settings.title.translate.x"
                         :formatter="formattedValue(widget.settings.title.translate.x, 'пикс')"
                         :max="100"
                         :min="-100"
                         tooltip="hover"
            />
            <RangeSlider v-model="widget.settings.title.translate.y"
                         :formatter="formattedValue(widget.settings.title.translate.y, 'пикс')"
                         :max="100"
                         :min="-100"
                         tooltip="hover"
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
          text_template: '{ sender } - { sum }',
          align: 'left',
          marquee_duration: 10,
          slider_speed: 2000,
          title: {
            text: 'Заголовок',
            color: '#000000',
            'font-family': 'Google Sans',
            background: 'transparent',
            'border-radius': 0,
            padding: 0,
            'font-size': 24,
            '-webkit-text-stroke-color': 'transparent',
            '-webkit-text-stroke-width': 0,
            translate: {
              x: 0,
              y: 0,
            },
            'font-style': 'normal',
            'font-weight': 'normal',
            'text-decoration': 'none',
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
