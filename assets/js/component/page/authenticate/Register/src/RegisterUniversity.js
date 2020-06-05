import React, {useEffect, useState} from 'react';
import {bindActionCreators} from "redux";
import {push} from "connected-react-router";
import {connect} from "react-redux";
import axios from "axios";
import {alert, alertException} from "../../../../src/Alert/Alert";
import {validateForm} from "../../../../src/FormValidation";
import {preloaderEnd, preloaderStart} from "../../../../src/Preloader/Preloader";
import { withRouter } from 'react-router-dom';

function index(props) {
    const [code, setCode] = useState('');
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');

    const handleSubmit = (e) => {
        e.preventDefault();
        if (!validateForm('register-university')) {
            return;
        }

        let formData = new FormData();
        formData.set('code', code);
        formData.set('User[email]', email);
        formData.set('User[password]', password);

        preloaderStart();
        axios.post('/react/register/create-university-user', formData)
            .then((res) => {
                let data = res.data;
                if (!data.status) {
                    alert('error', data.error);
                    return;
                }
                redirect(`/register/confirm-email-send/${data.code}`)
            })
            .catch((error) => {alertException(error.response.status)})
            .then(() => { preloaderEnd() });
    };

    const redirect = (url) => {
        props.push(url);
        props.history.push(url);
    };

    return (
        <form className={'register-university'} onSubmit={(e) => handleSubmit(e)} autoComplete="off" noValidate>
            <div className={`form-group`}>
                <input
                    name={'email'}
                    className={`form-control input input-type-1 w-100`}
                    placeholder={'Код доступа'}
                    type="text"
                    value={code}
                    onChange={(e) => setCode(e.target.value)}
                    autoComplete={'off'}
                    required
                />
                <span className={'error'} />
            </div>
            <div className={`form-group`}>
                <input
                    name={'email'}
                    className={`form-control input input-type-1 w-100`}
                    placeholder={'Email'}
                    type="email"
                    value={email}
                    onChange={(e) => setEmail(e.target.value)}
                    autoComplete={'off'}
                    required
                />
                <span className={'error'} />
            </div>

            <div className={`form-group`}>
                <input className={'form-control input input-type-1 w-100'}
                       placeholder={'Пароль'}
                       type="password"
                       value={password}
                       onChange={(e) => setPassword(e.target.value)}
                       autoComplete={'new-password'}
                       required
                />
                <span className={'error'} />
            </div>
            <button type="submit" className={"w-100 btn btn-type-2"}>Подтвердить</button>
        </form>
    );
}


function matchDispatchToProps(dispatch) {
    return bindActionCreators({push: push}, dispatch)
}

export default withRouter(connect(null, matchDispatchToProps)(index));