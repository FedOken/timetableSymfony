let model = {
  isLoading: false,
  error: null,
  data: {},
};
let relation = {
  isLoading: false,
  error: null,
  data: {},
};
let data = {
  model: model,
  relation: relation,
};

export default function user(state = data, action) {
  switch (action.type) {
    case 'USER_LOGIN':
      return Object.assign({}, state, {isLogin: true}, action.payload);

    case 'USER_UPDATE_LOADING':
      return {
        ...state,
        model: {
          ...model,
          isLoading: true,
        },
      };
    case 'USER_UPDATE_SUCCESS':
      return {
        ...state,
        model: {
          ...model,
          isLoading: false,
          data: action.payload,
        },
      };
    case 'USER_UPDATE_FAILURE':
      return {
        ...state,
        model: {
          ...model,
          isLoading: false,
          error: action.payload,
        },
      };

    case 'USER_RELATION_LOADING':
      return {
        ...state,
        relation: {
          ...relation,
          isLoading: true,
        },
      };
    case 'USER_RELATION_SUCCESS':
      return {
        ...state,
        relation: {
          ...relation,
          isLoading: false,
          data: action.payload,
        },
      };
    case 'USER_RELATION_FAILURE':
      return {
        ...state,
        relation: {
          ...relation,
          isLoading: false,
          error: action.payload,
        },
      };

    case 'USER_LOGOUT':
      return data;
    default:
      return state;
  }
}
