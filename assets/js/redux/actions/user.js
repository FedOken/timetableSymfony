import axios from 'axios';
import {alertException} from '../../component/src/Alert/Alert';
import {preloaderEnd, preloaderStart} from '../../component/src/Preloader/Preloader';

export const userLogout = () => {
  return {
    type: 'USER_LOGOUT',
  };
};

const updateStarted = () => ({
  type: 'USER_LOADING',
});

const updateSuccess = (data) => ({
  type: 'USER_SUCCESS',
  payload: data,
});

const updateFailure = (error) => ({
  type: 'USER_FAILURE',
  payload: error,
});

export const userUpdate = (data) => {
  return (dispatch) => {
    preloaderStart();
    dispatch(updateStarted(data));
    axios
      .post(`/react/layout/get-user`)
      .then((res) => {
        if (res.data.status) {
          return dispatch(updateSuccess(res.data.data));
        }
        dispatch(updateFailure(res.data.error));
      })
      .catch((error) => {
        dispatch(updateFailure(error.message));
        alertException(error);
      })
      .then(() => {
        preloaderEnd();
      });
  };
};
