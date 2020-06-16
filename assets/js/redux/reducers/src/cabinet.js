let data = {
  isLoading: false,
  error: null,
  loadedBuilding: [],
  data: [],
};

export default function user(state = data, action) {
  switch (action.type) {
    case 'CABINET_LOADING':
      return {
        ...state,
        isLoading: true,
        error: null,
      };
    case 'CABINET_SUCCESS':
      return {
        ...state,
        isLoading: false,
        loadedBuilding: [...state.loadedBuilding, action.buildingId],
        data: [...state.data, ...action.payload],
      };
    case 'CABINET_FAILURE':
      return {
        ...state,
        isLoading: false,
        error: action.payload,
      };
    default:
      return state;
  }
}
