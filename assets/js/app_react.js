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
                    value: 80,
                    density: {
                        enable: true,
                        value_area: 800
                    }
                },
                color: {
                    value: '#000000'
                },
                shape: {
                    type: "circle",
                    stroke: {
                        width: 0,
                        color: "#000000"
                    },
                    polygon: {
                        nb_sides: 5
                    },
                    image: {
                        src: 'img/github.svg',
                        width: 100,
                        height: 100
                    }
                },
                line_linked: {
                    enable: true,
                    distance: 300,
                    color: "#000000",
                    opacity: 0.4,
                    width: 2
                },
            }
        }} />
        <Header />
        <Content />
        <Footer />
    </BrowserRouter>
), document.getElementById('main-block'));




