import Vue from 'vue';

Vue.directive('click-outside', {
  priority: 700,
  bind(el, building, node) {
    const self = node.context;
    self.event = function (event) {
      console.log('emitting event');
      self.$emit(self.expression, event);
    };
    el.addEventListener('click', self.stopProp);
    document.body.addEventListener('click', self.event);
  },

  unbind() {
    console.log('unbind');
    this.el.removeEventListener('click', this.stopProp);
    document.body.removeEventListener('click', this.event);
  },
  stopProp(event) { event.stopPropagation(); },
});
