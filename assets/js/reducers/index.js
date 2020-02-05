import { combineReducers } from "redux";
import { routerReducer } from "react-router-redux";

import test from './test'
import login from './login/index'
import header from './header/index'

export default combineReducers({
    routing: routerReducer,
    someKey: test,
    userData: login,
    header: header,
});