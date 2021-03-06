import { blockStyleType } from '@/types/SVGblock';

export const statsWidgetType = {
  title: blockStyleType,
  marquee_duration: {
    type: Number,
    default: 10,
  },
  text_template: {
    type: String,
    default: '{ donation_sender } - { sum }',
  },
  align: {
    type: String,
    default: 'center',
  },
  slider_speed: {
    type: Number,
    default: 2000,
  },
  widget_view_type: {
    type: String,
    default: 'marquee',
  },
};

export default { statsWidgetType };
