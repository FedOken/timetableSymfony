import { combineReducers } from "redux";
import { connectRouter } from 'connected-react-router'

import header from './header/index'
import user from './user/index'

const createRootReducer  = (history) => combineReducers({
    router: connectRouter(history),
    header: header,
    user: user,
});
export default createRootReducer;