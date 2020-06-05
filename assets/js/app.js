import React from 'react';
import ReactDom from 'react-dom';
import { BrowserRouter } from 'react-router-dom'
import Particles from './component/src/Particles';
import { Provider } from 'react-redux';
import configureStore, { history } from './redux/configureStore';
import { ConnectedRouter } from 'connected-react-router'
import Layout from './component/layout/Layout';
import Alert from "./component/src/Alert/Alert";
import Preloader from "./component/src/Preloader/Preloader";
import '../css/app.scss'

const store = configureStore();

ReactDom.render((

    <Provider store={store}>
        <ConnectedRouter history={history}>
            <BrowserRouter>
                <Particles />
                <Alert />
                <Preloader />
                <Layout />
            </BrowserRouter>
        </ConnectedRouter>
    </Provider>
), document.getElementById('main-block'));




