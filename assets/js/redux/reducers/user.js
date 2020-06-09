let data = {
  isLogin: false,
  data: {},
}

export default function user(state = data, action) {
  switch (action.type) {
    case 'USER_LOGIN':
      return Object.assign({}, state, {isLogin: true}, action.payload)
    case 'USER_LOGOUT':
      return {
        isLogin: false,
        data: {},
      }
    default:
      return state
  }
}
