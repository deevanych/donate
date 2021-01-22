import Vue from 'vue';

export default {
  sendRequest(
    url = '',
    successCallback = null,
    errorCallback = null,
    finallyCallback = null,
    method = 'get',
    data = {},
  ) {
    Vue.prototype.$http({
      method,
      url,
      data,
    })
      .then((res) => {
        if (successCallback != null) {
          successCallback(res);
        }
      })
      .catch((err) => {
        if (errorCallback != null) {
          errorCallback(err);
        }
      })
      .finally(() => {
        if (finallyCallback != null) {
          finallyCallback();
        }
      });
  },
};
