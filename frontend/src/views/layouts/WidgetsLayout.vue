<template>
  <router-view/>
</template>

<script>
import fonts from '@/api/fonts';

export default {
  name: 'WidgetLayout',
  mounted() {
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
    });
  },
};
</script>

<style scoped>

</style>
