import api from './api';

export default {
  get(userName = '', successCallback = null, errorCallback = null) {
    api.sendRequest(`users/${userName}`, successCallback, errorCallback);
  },
};
