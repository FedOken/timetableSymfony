import axios from 'axios';
import {alertException} from '../../component/src/Alert/Alert';
import {preloaderEnd, preloaderStart} from '../../component/src/Preloader/Preloader';
import {isEmpty} from '../../component/src/Helper';

/*-------------------------*/
const loading = () => ({
  type: 'UNIVERSITY_LOADING',
});
const success = (data) => ({
  type: 'UNIVERSITY_SUCCESS',
  payload: data,
});
const failure = (error) => ({
  type: 'UNIVERSITY_FAILURE',
  payload: error,
});
export const loadUniversities = () => {
  return (dispatch, getState) => {
    if (!isEmpty(getState().university.data)) return;

    preloaderStart();
    dispatch(loading());
    axios
      .post(`/api/university/get-universities`)
      .then((res) => {
        if (res.data.status) {
          return dispatch(success(res.data.data));
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
