let data = {
  isLoading: false,
  error: null,
  loadedUn: [],
  data: [],
};

export default function user(state = data, action) {
  switch (action.type) {
    case 'BUILDING_LOADING':
      return {
        ...state,
        isLoading: true,
        error: null,
      };
    case 'BUILDING_SUCCESS':
      return {
        ...state,
        isLoading: false,
        loadedUn: [...state.loadedUn, action.unId],
        data: [...state.data, ...action.payload],
      };
    case 'BUILDING_FAILURE':
      return {
        ...state,
        isLoading: false,
        error: action.payload,
      };
    default:
      return state;
  }
}
