let data = {
  isLoading: false,
  isLoaded: false,
  error: null,
  data: {},
};

export default function user(state = data, action) {
  switch (action.type) {
    case 'UNIVERSITY_LOADING':
      return {
        ...state,
        isLoading: true,
      };
    case 'UNIVERSITY_SUCCESS':
      return {
        ...state,
        isLoading: false,
        isLoaded: true,
        data: action.payload,
      };
    case 'UNIVERSITY_FAILURE':
      return {
        ...state,
        isLoading: false,
        isLoaded: true,
        error: action.payload,
      };
    default:
      return state;
  }
}
