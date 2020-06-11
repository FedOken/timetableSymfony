import {combineReducers} from 'redux';
import {connectRouter} from 'connected-react-router';

import user from './src/user';

const createRootReducer = (history) =>
  combineReducers({
    router: connectRouter(history),
    user: user,
  });

export default createRootReducer;
