import React from 'react';
import ReactDom from 'react-dom';
import { BrowserRouter } from 'react-router-dom';

import Header from "./Components/LayoutComponents/Header/Header";
import Content from "./Components/LayoutComponents/Content";
import Footer from "./Components/LayoutComponents/Footer";

ReactDom.render((
    <BrowserRouter>
        <Header />
        <Content />
        <Footer />
    </BrowserRouter>
), document.getElementById('main-block'));




