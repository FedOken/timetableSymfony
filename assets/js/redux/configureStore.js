import {createBrowserHistory} from 'history';
import {applyMiddleware, compose, createStore} from 'redux';
import {routerMiddleware} from 'connected-react-router';
import createRootReducer from './reducers/index';
import thunk from 'redux-thunk';

export const history = createBrowserHistory();

const composeEnhancer = window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__ || compose;

export default function configureStore() {
  return createStore(createRootReducer(history), composeEnhancer(applyMiddleware(routerMiddleware(history), thunk)));
}
