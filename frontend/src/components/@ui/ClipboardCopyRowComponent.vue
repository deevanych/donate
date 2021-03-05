<template>
  <vs-input v-model="value" border icon-after @focus.stop="copy" @click.stop>
    <template #icon>
      <i class='bx bx-copy'></i>
    </template>
  </vs-input>
</template>

<script>
export default {
  name: 'ClipboardCopyRow',
  props: {
    value: {
      type: String,
      required: true,
    },
  },
  methods: {
    copy() {
      this.$copyText(this.value).then(() => {
        this.$vs.notification({
          position: 'top-right',
          border: 'success',
          title: 'Ссылка скопирована',
          text: 'Никому не показывайте ссылку',
        });
      })
        .catch((err) => {
          this.$vs.notification({
            position: 'top-right',
            border: 'danger',
            title: 'Произошла ошибка',
            text: err,
          });
        });
    },
  },
};
</script>

<style lang="scss" scoped>
.vs-input-parent::v-deep {
  input {
    filter: blur(3px);
    transition: .3s;

    &:hover {
      filter: blur(1px);
    }
  }
}

</style>
