let data = {
  isLoading: false,
  error: null,
  isLoaded: false,
  data: {},
};

export default function user(state = data, action) {
  switch (action.type) {
    case 'USER_LOGIN':
      return Object.assign({}, state, {isLogin: true}, action.payload);
    case 'USER_LOADING':
      return {
        ...state,
        isLoading: true,
        error: null,
        isLoaded: false,
        data: {},
      };
    case 'USER_SUCCESS':
      return {
        ...state,
        isLoading: false,
        isLoaded: true,
        data: action.payload,
      };
    case 'USER_FAILURE':
      return {
        ...state,
        isLoading: false,
        isLoaded: true,
        error: action.payload,
      };
    case 'USER_LOGOUT':
      return data;
    default:
      return state;
  }
}
