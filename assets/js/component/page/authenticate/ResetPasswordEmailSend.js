import React, { useState } from 'react';
import Button from "react-bootstrap/Button";
import {bindActionCreators} from "redux";
import {push} from "connected-react-router";
import {connect} from "react-redux";
import Tabs from "react-bootstrap/Tabs";
import {Tab} from "react-bootstrap";
import Select from "../../src/Select";

function index(props) {

    const redirect = (url) => {
        props.push(url);
        props.history.push(url);
    };

    return (
        <div className="reset-password-email-send container">
            <p className={'title'}>Письмо с новым паролем отправлено на Вашу почту!</p>
            <div>
                <button type={'button'} className={"btn btn-type-1"} onClick={() => redirect('/search')}>К поиску</button>
                <button type={'button'} className={"btn btn-type-2"} onClick={() => redirect('/login')}>На страницу входа</button>
            </div>
        </div>
    );
}


function matchDispatchToProps(dispatch) {
    return bindActionCreators({push: push}, dispatch)
}

export default connect(null, matchDispatchToProps)(index);