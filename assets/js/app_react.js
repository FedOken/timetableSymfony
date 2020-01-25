import React from 'react';
import ReactDom from 'react-dom';
import { BrowserRouter as Router, Route } from 'react-router-dom'
import Particles from "react-particles-js";
import { transitions, positions, Provider as AlertProvider } from 'react-alert'
import { Provider } from 'react-redux';
import { createStore } from 'redux';
import { syncHistoryWithStore } from 'react-router-redux'

import CustomAlertTemplate from "./Components/src/CustomAlertTemplate";
import Header from "./Components/LayoutComponents/Header/Header";
import Content from "./Components/LayoutComponents/Content";
import Footer from "./Components/LayoutComponents/Footer";


const alertOption = {
    position: positions.TOP_CENTER,
    timeout: 5000,
    offset: '125px',
    transition: transitions.SCALE,
    containerStyle: {
        zIndex: 100
    }
};

const particlesOption = {
    particles: {
        number: {
            value: 150,
            density: {
                enable: true,
                value_area: 1000
            }
        },
        color: {
            value: '#4a707a'
        },
        move: {
            speed: 2,
        },
        line_linked: {
            enable: true,
            distance: 100,
            color: "#4a707a",
            opacity: 0.4,
            width: 1
        },

    }
};

import reducer from './reducers';

const store = createStore(reducer, window.__REDUX_DEVTOOLS_EXTENSION__ && window.__REDUX_DEVTOOLS_EXTENSION__());
//const history = syncHistoryWithStore(browserHistory, store)

ReactDom.render((
    <Provider store={store}>
        <Router>
            <AlertProvider template={CustomAlertTemplate} {...alertOption}>
                <Particles className={'div-particles'} params={particlesOption} />
                <Header />
                <Content />
                <Footer />
            </AlertProvider>
        </Router>
    </Provider>
), document.getElementById('main-block'));




