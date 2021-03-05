import Vue from 'vue';

export const getFonts = () => Vue.prototype.$http({
  method: 'GET',
  url: 'https://www.googleapis.com/webfonts/v1/webfonts',
  params: {
    key: 'AIzaSyC2OsmWwJxc4UCY2lQoPxPW68dd9bO-nzA',
    sort: 'POPULARITY',
  },
});

export const getFontsStyles = (url = 'https://fonts.googleapis.com/css') => new Promise((resolve, reject) => {
  const request = new XMLHttpRequest();
  request.overrideMimeType('application/json');
  request.open('GET', url, true);
  request.onreadystatechange = () => {
    if (request.readyState === 4) {
      if (request.status !== 200) {
        reject(new Error(`Response has status code ${request.status}`));
      } else {
        resolve(request.responseText);
      }
    }
  };
  request.send();
});
