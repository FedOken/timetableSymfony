import axios from 'axios';
import {alertException} from '../../component/src/Alert/Alert';
import {preloaderEnd, preloaderStart} from '../../component/src/Preloader/Preloader';

/*-------------------------*/
const loading = () => ({
  type: 'CABINET_LOADING',
});
const success = (data, buildingId) => ({
  type: 'CABINET_SUCCESS',
  payload: data,
  buildingId: buildingId,
});
const failure = (error) => ({
  type: 'CABINET_FAILURE',
  payload: error,
});
export const loadCabinetsByBuilding = (unId) => {
  return (dispatch, getState) => {
    /** Dont upload existing parties */
    if (getState().cabinet.loadedBuilding.includes(unId)) return;

    preloaderStart();
    dispatch(loading());
    axios
      .post(`/api/cabinet/get-cabinets-by-building/${unId}`)
      .then((res) => {
        if (res.data.status) {
          return dispatch(success(res.data.data, res.data.buildingId));
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
