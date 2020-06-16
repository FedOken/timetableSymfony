import axios from 'axios';
import {alertException} from '../../component/src/Alert/Alert';
import {preloaderEnd, preloaderStart} from '../../component/src/Preloader/Preloader';

/*-------------------------*/
const loading = () => ({
  type: 'BUILDING_LOADING',
});
const success = (data, unId) => ({
  type: 'BUILDING_SUCCESS',
  payload: data,
  unId: unId,
});
const failure = (error) => ({
  type: 'BUILDING_FAILURE',
  payload: error,
});
export const loadBuildingsByUniversity = (unId) => {
  return (dispatch, getState) => {
    /** Dont upload existing parties */
    if (getState().building.loadedUn.includes(unId)) return;

    preloaderStart();
    dispatch(loading());
    axios
      .post(`/api/building/get-buildings-by-university/${unId}`)
      .then((res) => {
        if (res.data.status) {
          return dispatch(success(res.data.data, res.data.unId));
        }
        dispatch(failure(res.data.error));
      })
      .catch((error) => {
        dispatch(failure(error.message));
        alertException(error);
      })
      .then(() => {
        preloaderEnd();
      });
  };
};
