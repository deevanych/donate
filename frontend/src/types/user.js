import { settingsType as settings } from '@/types/settings';

export const user = {
  name: '',
  avatar_url: '',
  email: '',
  social_networks: [
    {
      title: '',
      pivot: {
        link: '',
      },
    },
  ],
  settings,
};

export { user as userType };
