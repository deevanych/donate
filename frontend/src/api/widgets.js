import Vue from 'vue';

export const getList = () => Vue.prototype.$http({
  method: 'GET',
  url: '/widgets',
});

export const createWidget = (data) => Vue.prototype.$http({
  method: 'POST',
  url: '/widgets',
  data,
});

export const updateWidget = (widgetId, data) => Vue.prototype.$http({
  method: 'PUT',
  url: `/widgets/${widgetId}`,
  data,
});

export const get = (widgetId) => Vue.prototype.$http({
  method: 'GET',
  url: `/widgets/${widgetId}`,
});

export const remove = (widgetId) => Vue.prototype.$http({
  method: 'DELETE',
  url: `/widgets/${widgetId}`,
});

export const restore = (widgetId) => Vue.prototype.$http({
  method: 'PUT',
  url: `/widgets/${widgetId}`,
  data: {
    deleted_at: null,
  },
});

export const getData = (widgetId) => Vue.prototype.$http({
  method: 'GET',
  url: `/widgets/${widgetId}/data`,
});
