const donations = [
  {
    id: 1,
    donation_sender: 'Преданный малыш',
    sum: 403,
  },
  {
    id: 2,
    donation_sender: 'Джежай',
    sum: 32,
  },
  {
    id: 3,
    donation_sender: 'Энигма',
    sum: 143,
  },
  {
    id: 4,
    donation_sender: 'Пикачу',
    sum: 3,
  },
];

const donation = {
  text: '',
  donation_sender: '',
  sum: '',
  goal_id: null,
  media: '',
};

export { donations as donationsType, donation as donationType };
