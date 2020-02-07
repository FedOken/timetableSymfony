import { combineReducers } from "redux";
import { routerReducer } from "react-router-redux";

import login from './login/index'
import header from './header/index'
import user from './user/index'

export default combineReducers({
    routing: routerReducer,
    userData: login,
    header: header,
    user: user,
});