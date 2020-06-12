import axios from 'axios';
import {alertException} from '../../component/src/Alert/Alert';
import {preloaderEnd, preloaderStart} from '../../component/src/Preloader/Preloader';

export const userLogout = () => {
  return {
    type: 'USER_LOGOUT',
  };
};

/*-------------------------*/
const modelLoading = () => ({
  type: 'USER_UPDATE_LOADING',
});
const modelSuccess = (data) => ({
  type: 'USER_UPDATE_SUCCESS',
  payload: data,
});
const modelFailure = (error) => ({
  type: 'USER_UPDATE_FAILURE',
  payload: error,
});
export const loadUserModel = (data) => {
  return (dispatch) => {
    preloaderStart();
    dispatch(modelLoading(data));
    axios
      .post(`/api/user/get-user`)
      .then((res) => {
        if (res.data.status) {
          return dispatch(modelSuccess(res.data.data));
        }
        dispatch(modelFailure(res.data.error));
      })
      .catch((error) => {
        dispatch(modelFailure(error.message));
        alertException(error);
      })
      .then(() => {
        preloaderEnd();
      });
  };
};

/*-------------------------*/
const relationLoading = () => ({
  type: 'USER_RELATION_LOADING',
});
const relationSuccess = (data) => ({
  type: 'USER_RELATION_SUCCESS',
  payload: data,
});
const relationFailure = (error) => ({
  type: 'USER_RELATION_FAILURE',
  payload: error,
});
export const loadUserRelation = (data) => {
  return (dispatch) => {
    preloaderStart();
    dispatch(relationLoading(data));
    axios
      .post(`/api/user/get-relation`)
      .then((res) => {
        if (res.data.status) {
          return dispatch(relationSuccess(res.data.data));
        }
        dispatch(relationFailure(res.data.error));
      })
      .catch((error) => {
        dispatch(relationFailure(error.message));
        alertException(error);
      })
      .then(() => {
        preloaderEnd();
      });
  };
};
