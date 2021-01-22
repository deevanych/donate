import api from './api';

export default {
  send(
    userName = '',
    donation = {},
    successCallback = null,
    errorCallback = null,
    finallyCallback = null,
  ) {
    api.sendRequest(`users/${userName}/donations`, successCallback, errorCallback, finallyCallback, 'post', donation);
  },
};
