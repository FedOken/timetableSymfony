import React from 'react';
import ReactDom from 'react-dom';
import Login from './Components/LoginComponent/Login'

ReactDom.render(<Login testprops={'aaaa'}/>, document.getElementById('main-block'));
