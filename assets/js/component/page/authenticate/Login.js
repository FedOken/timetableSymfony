import React, { useState } from 'react';
import Button from "react-bootstrap/Button";
import {bindActionCreators} from "redux";
import {push} from "connected-react-router";
import {connect} from "react-redux";

function index(props) {

    const clickRegister = () => {
        redirect('/register')
    };

    const clickResetPassword = () => {
        redirect('/reset-password')
    };

    const clickLogin = () => {
        redirect('/profile')
    };

    const redirect = (url) => {
        props.push(url);
        props.history.push(url);
    };

    return (
        <div className="login container">
            <div className="col-xs-12 col-sm-6 col-md-4 block-center">
                <div className={'block-login'}>
                    <form>
                        <input className={'form-control input input-type-1 w-100'} placeholder={'Email'} type="text"/>
                        <input className={'form-control input input-type-1 w-100'} placeholder={'Пароль'} type="text"/>
                        <Button type="button" className={"w-100"} variant="type-2" onClick={() => clickLogin()}>Войти</Button>
                        <div className={'block-additional'}>
                            <p>Все еще нет аккаунта? <span onClick={() => clickRegister()}>Создайте</span></p>
                            <p>Забыли пароль? <span onClick={() => clickResetPassword()}>Восстановите!</span></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    );
}


function matchDispatchToProps(dispatch) {
    return bindActionCreators({push: push}, dispatch)
}

export default connect(null, matchDispatchToProps)(index);