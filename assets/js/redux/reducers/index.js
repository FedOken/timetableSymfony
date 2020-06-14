import {combineReducers} from 'redux';
import {connectRouter} from 'connected-react-router';

import user from './src/user';
import university from './src/university';
import party from './src/party';

const createRootReducer = (history) =>
  combineReducers({
    router: connectRouter(history),
    user: user,
    university: university,
    party: party,
  });

export default createRootReducer;
