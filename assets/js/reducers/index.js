import { combineReducers } from "redux";
import { routerReducer } from "react-router-redux";

import test from './test'
import login from './login/index'

export default combineReducers({
    routing: routerReducer,
    test,
    login
});