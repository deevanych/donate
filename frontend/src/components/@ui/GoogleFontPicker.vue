<template>
  <vs-select
    v-if="fonts.length !== 0"
    filter
    placeholder="Название шрифта"
    :value="value"
    @input="$emit('input', $event)"
  >
    <vs-option label="по умолчанию" value="Google Sans">
      по умолчанию
    </vs-option>
    <vs-option v-for="font in fonts" :key="font.family" :label="font.family" :value="font.family">
      <span :style="{'font-family': font.family}">{{ font.family }}</span>
    </vs-option>
  </vs-select>
</template>

<script>
import fonts from '@/api/fonts';

export default {
  name: 'GoogleFontPicker',
  props: {
    value: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      fonts: [],
    };
  },
  beforeCreate() {
    fonts.getFonts().then((res) => {
      this.fonts = res.data.items.slice(0, 30).filter((font) => {
        let find = false;
        font.subsets.forEach((subset) => {
          if (subset === 'cyrillic') {
            find = true;
            return true;
          }
          return false;
        });
        return find;
      });
      const url = new URL('https://fonts.googleapis.com/css');
      const familiesStr = this.fonts.map((font) => `${font.family}:"regular,700"`);
      url.searchParams.append('family', familiesStr.join('|'));
      url.searchParams.append('font-display', 'swap');
      fonts.getFontsStyles(url.href).then((fontsStyles) => {
        const style = document.createElement('style');
        style.type = 'text/css';
        style.innerHTML = fontsStyles.toString();
        document.head.appendChild(style);
      })
        .catch((err) => {
          console.log(err);
        });
    }).catch((err) => {
      this.$vs.notification({
        position: 'top-right',
        border: 'danger',
        title: 'Ошибка',
        text: err,
      });
    });
  },
};
</script>

<style scoped>

</style>
