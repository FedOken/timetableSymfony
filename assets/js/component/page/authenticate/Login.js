import React, {useEffect, useState} from 'react';
import Button from "react-bootstrap/Button";
import {bindActionCreators} from "redux";
import {push} from "connected-react-router";
import {connect} from "react-redux";
import {preloaderEnd, preloaderStart} from "../../src/Preloader";
import axios from "axios";
import {alertException} from "../../src/Alert";

function index(props) {
    const [token, setToken] = useState();

    useEffect(() => {
        preloaderStart();
        axios.post(`/react/login/get-csrf-token`)
            .then((res) => {
                setToken(res.data);
            })
            .catch((error) => {alertException(error.response.status)})
            .then(() => { preloaderEnd() });
    }, []);

    const clickRegister = () => {
        redirect('/register')
    };

    const clickResetPassword = () => {
        redirect('/reset-password')
    };

    const clickLogin = () => {
        let formData = new FormData();
        formData.set('email', 'admin@gmail.com');
        formData.set('password', '123456');
        formData.set('_csrf_token', token);
        console.log(token);

        //preloaderStart();
        axios.post(`/react/login/login`, formData)
            .then((res) => {
                console.log(res.data);
            })
            .catch((error) => {al
                ertException(error.response.status)})
            .then(() => { preloaderEnd() });
        //redirect('/profile')
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