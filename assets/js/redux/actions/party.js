import axios from 'axios';
import {alertException} from '../../component/src/Alert/Alert';
import {preloaderEnd, preloaderStart} from '../../component/src/Preloader/Preloader';

/*-------------------------*/
const loading = () => ({
  type: 'PARTY_LOADING',
});
const success = (data, unId) => ({
  type: 'PARTY_SUCCESS',
  payload: data,
  unId: unId,
});
const failure = (error) => ({
  type: 'PARTY_FAILURE',
  payload: error,
});
export const loadPartiesByUniversity = (unId) => {
  return (dispatch, getState) => {
    /** Dont upload existing parties */
    if (getState().party.loadedUn.includes(unId)) return;

    dispatch(loading());
    axios
      .post(`/api/party/get-parties-by-university/${unId}`)
      .then((res) => {
        if (res.data.status) {
          return dispatch(success(res.data.data, res.data.unId));
        }
        dispatch(failure(res.data.error));
      })
      .catch((error) => {
        dispatch(failure(error.message));
        alertException(error);
      });
  };
};
