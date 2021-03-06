export const appearance = {
  // shadow
  shadowEnabled: false,
  shadowColor: '#000000',
  shadowBlur: 2,
  shadowPosition: {
    x: 2,
    y: -2,
  },

  // stroke
  strokeEnabled: false,
  strokeColor: '{"angle":0,"stops":[["#0359b5",0],["#f6ce01",1]]}',
  strokeWidth: 1,

  // text
  text: 'Заголовок',
  color: '{"angle":0,"stops":[["#0359b5",0],["#f6ce01",1]]}',
  fontFamily: 'Google Sans',
  fontStyle: 'normal',
  fontWeight: 'normal',
  textDecoration: 'none',

  // position
  block: {
    coords: {
      w: 100,
      h: 100,
      x: 50,
      y: 20,
      angle: 0,
      zoom: 1,
    },

    // background
    padding: 0,
    backgroundColorEnabled: false,
    backgroundColor: '{"angle":0,"stops":[["#FFFFFF",0],["#f6ce01",1]]}',
    backgroundStrokeEnabled: false,
    backgroundStrokeRadius: 0,
    backgroundStrokeWidth: 2,
    backgroundStrokeColor: '#000000',
    backgroundShadowEnabled: false,
    backgroundShadowColor: '#000000',
    backgroundShadowBlur: 2,
    backgroundShadowPosition: {
      x: 2,
      y: -2,
    },
  },
};

export { appearance as blockStyleType };
