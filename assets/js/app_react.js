import React from 'react';
import ReactDom from 'react-dom';
import { BrowserRouter } from 'react-router-dom';

import Header from "./Components/LayoutComponents/Header/Header";
import Content from "./Components/LayoutComponents/Content";
import Footer from "./Components/LayoutComponents/Footer";
import Particles from "react-particles-js";

ReactDom.render((
    <BrowserRouter>
        <Particles className={'div-particles'} params={{
            particles: {
                number: {
                    value: 75,
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
        }} />
        <Header />
        <Content />
        <Footer />
    </BrowserRouter>
), document.getElementById('main-block'));




