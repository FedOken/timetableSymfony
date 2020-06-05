import React, {useEffect, useState} from 'react';
import {bindActionCreators} from "redux";
import {push} from "connected-react-router";
import {connect} from "react-redux";
import Select from "../../../../src/Select";
import axios from "axios";
import {alert, alertException} from "../../../../src/Alert/Alert";
import {validateForm} from "../../../../src/FormValidation";
import {isEmpty} from "../../../../src/Helper";
import {preloaderEnd, preloaderStart} from "../../../../src/Preloader/Preloader";
import { withRouter } from 'react-router-dom';

function index(props) {
    const [selUnIsDisabled, setSelUnIsDisabled] = useState(true);

    const [selTchrOpt, setSelTchrOpt] = useState([]);
    const [selTchrValue, setSelTchrValue] = useState();
    const [selTchrIsDisabled, setSelTchrIsDisabled] = useState(true);
    const [selectedTchr, setSelectedTchr] = useState();

    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');

    useEffect(() => {
        if (!isEmpty(props.selUnOpt)) {
            setSelUnIsDisabled(false);
        }
    });

    const selUnOnChange = (data) => {
        if (typeof data.value === 'undefined') return;

        setSelTchrValue('');
        setSelectedTchr(null);
        setSelTchrIsDisabled(true);

        axios.post('/react/search/get-teachers/' + data.value)
            .then((res) => {
                setSelTchrOpt(res.data);
                setSelTchrIsDisabled(false);
            })
            .catch((error) => {alertException(error.response.status)});
    };

    const selTchrOnChange = (data) => {
        if (isEmpty(data.value)) return;
        setSelTchrValue(data);
        setSelectedTchr(data.value);
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        if (!validateForm('register-teacher', {selTchr: selectedTchr})) {
            return;
        }

        let formData = new FormData();
        formData.set('id', selectedTchr);
        formData.set('User[email]', email);
        formData.set('User[password]', password);

        preloaderStart();
        axios.post('/react/register/create-teacher-user', formData)
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
        <form className={'register-teacher'} onSubmit={(e) => handleSubmit(e)} autoComplete="off" noValidate>
            <Select
                options={props.selUnOpt}
                placeholder={'Выберите университет'}
                className={'select select-type-1 ' + (selUnIsDisabled ? 'disabled' : '')}
                onChange={ (data) => {selUnOnChange(data)} }
            />
            <div className={`form-group`} id={'selTchr'}>
                <Select
                    options={selTchrOpt}
                    value={selTchrValue}
                    placeholder={'Выберите группу'}
                    className={'select select-type-1 ' + (selTchrIsDisabled ? 'disabled' : '')}
                    onChange={ (data) => {selTchrOnChange(data)} }
                    isDisabled={selTchrIsDisabled}
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