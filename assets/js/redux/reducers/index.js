import { combineReducers } from "redux";
import { routerReducer } from "react-router-redux";

import header from './header/index'
import user from './user/index'

export default combineReducers({
    routing: routerReducer,
    header: header,
    user: user,
});