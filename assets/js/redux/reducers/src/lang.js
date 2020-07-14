let data = 'uk-UA';

export default function user(state = data, action) {
  switch (action.type) {
    case 'CHANGE_LANG':
      return action.payload;
    default:
      return state;
  }
}
