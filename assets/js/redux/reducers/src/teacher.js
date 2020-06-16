let data = {
  isLoading: false,
  error: null,
  loadedUn: [],
  data: [],
};

export default function user(state = data, action) {
  switch (action.type) {
    case 'TEACHER_LOADING':
      return {
        ...state,
        isLoading: true,
        error: null,
      };
    case 'TEACHER_SUCCESS':
      return {
        ...state,
        isLoading: false,
        loadedUn: [...state.loadedUn, action.unId],
        data: [...state.data, ...action.payload],
      };
    case 'TEACHER_FAILURE':
      return {
        ...state,
        isLoading: false,
        error: action.payload,
      };
    default:
      return state;
  }
}
