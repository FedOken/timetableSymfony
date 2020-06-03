import React, { useState } from 'react';
import Button from "react-bootstrap/Button";
import {bindActionCreators} from "redux";
import {push} from "connected-react-router";
import {connect} from "react-redux";
import {validateForm} from "../../src/FormValidation";
import {preloaderEnd, preloaderStart} from "../../src/Preloader";
import axios from "axios";
import {alert, alertException} from "../../src/Alert";

function index(props) {
    const [email, setEmail] = useState('');

    const handleSubmit = (e) => {
        e.preventDefault();
        if (!validateForm('reset-password-form')) {
            return;
        }

        let formData = new FormData();
        formData.set('User[email]', email);

        preloaderStart();
        axios.post('/react/reset-password', formData)
            .then((res) => {
                let data = res.data;
                if (!data.status) {
                    alert('error', data.error);
                    return;
                }
                redirect(`/reset-password/email-send`)
            })
            .catch((error) => {alertException(error.response.status)})
            .then(() => { preloaderEnd() });
    };

    const redirect = (url) => {
        props.push(url);
        props.history.push(url);
    };

    return (
        <div className="reset-password container">
            <div className="col-xs-12 col-sm-6 col-md-4 block-center">
                <div className={'block-reset'}>
                    <span className={'block-name'}>Вход</span>
                    <form className={'reset-password-form'} onSubmit={(e) => handleSubmit(e)} noValidate>

                        <div className={`form-group`}>
                            <input className={'form-control input input-type-1 w-100'}
                                   placeholder={'Email'}
                                   type="email"
                                   value={email}
                                   onChange={(e) => setEmail(e.target.value)}
                                   required
                            />
                            <span className={'error'} />
                        </div>
                        <button type={"submit"} className={"w-100 btn btn-type-2"}>Восстановить</button>
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
