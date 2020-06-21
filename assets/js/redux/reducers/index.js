import {combineReducers} from 'redux';
import {connectRouter} from 'connected-react-router';

import user from './src/user';
import university from './src/university';
import party from './src/party';
import teacher from './src/teacher';
import building from './src/building';
import cabinet from './src/cabinet';
import lang from './src/lang';

const createRootReducer = (history) =>
  combineReducers({
    router: connectRouter(history),
    lang: lang,
    user: user,
    university: university,
    party: party,
    teacher: teacher,
    building: building,
    cabinet: cabinet,
  });

export default createRootReducer;
