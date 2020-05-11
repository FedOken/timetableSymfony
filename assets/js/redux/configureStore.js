import { createBrowserHistory } from 'history'
import { applyMiddleware, compose, createStore } from 'redux'
import { routerMiddleware } from 'connected-react-router'
import createRootReducer from './reducers/index';

export const history = createBrowserHistory();

const composeEnhancer = window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__ || compose;

export default function configureStore() {
    const store = createStore(
        createRootReducer(history), // root reducer with router state
        composeEnhancer(
            applyMiddleware(
                routerMiddleware(history) // for dispatching history actions
                // ... other middlewares ...
            )
        )
    );

    return store
}