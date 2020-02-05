import React, { useState, useEffect } from 'react';
import axios from 'axios';
import Button from "react-bootstrap/Button";
import Form from "react-bootstrap/Form";
import {Redirect} from "react-router-dom";
import {useAlert} from 'react-alert'
import {connect} from 'react-redux';
import {bindActionCreators} from "redux";
import { changeLoginStatus } from "../../actions/login";

function Login(props) {
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [token, setToken] = useState('');
    const [successfulLogin, setSuccessfulLogin] = useState(false);

    useEffect(() => {
        axios.post(`/react/login/get-user-data`)
            .then(res => {
                setToken(res.data);
            });

    }, []);

    const alert = useAlert();

    const formOnSubmit = (event) => {
        event.preventDefault();

        let data = new FormData();
        data.set('email', email);
        data.set('password', password);
        data.set('_csrf_token', token);

        axios.post(`/react/login/login`, data).then(res => {
            if (res.data.status === 'ok') {
                //setSuccessfulLogin(true);
                alert.success(res.data.reason);
            } else {
                alert.error(res.data.reason);
            }

        });
    };

    const inputEmailOnChange = (event) => {
        setEmail( event.target.value )
    };

    const inputPasswordOnChange = (event) => {
        setPassword( event.target.value )
    };

    const changeState = () => {
      //console.log(props.loginStatus);
      //props.changeStatus( props.loginStatus + 1 );
    };

    //console.log
    return (
        <div className="container block-center-container login-container">
            <div className="col-xs-12 col-sm-6 col-md-4 col-lg-3 block-center">
                <Form onSubmit={formOnSubmit}>
                    <Form.Group controlId="login-email" >
                        <Form.Label>Enter email address</Form.Label>
                        <Form.Control type="email" name="email" required value={email} onChange={inputEmailOnChange} />
                    </Form.Group>

                    <Form.Group controlId="login-password">
                        <Form.Label>Enter password</Form.Label>
                        <Form.Control type="password" autoComplete="on" name="password" required value={password} onChange={inputPasswordOnChange} />
                    </Form.Group>
                    <input type="hidden" name="_csrf_token" value={token || ''}/>
                    <Button type="submit" className={"w-100"} variant="type-2">Submit</Button>
                </Form>
            </div>
        </div>
        // <p onClick={ () => {props.changeLoginStatus(true)} }>awdawdawd</p>
    );
    // if (successfulLogin) {
    //     return (
    //         <Redirect to="/" />
    //     )
    // } else {
    //     return (
    //         <div className="container block-center-container login-container">
    //             <div className="col-xs-12 col-sm-6 col-md-4 col-lg-3 block-center">
    //                 <Form onSubmit={formOnSubmit}>
    //                     <Form.Group controlId="login-email" >
    //                         <Form.Label>Enter email address</Form.Label>
    //                         <Form.Control type="email" name="email" required value={email} onChange={inputEmailOnChange} />
    //                     </Form.Group>
    //
    //                     <Form.Group controlId="login-password">
    //                         <Form.Label>Enter password</Form.Label>
    //                         <Form.Control type="password" autoComplete="on" name="password" required value={password} onChange={inputPasswordOnChange} />
    //                     </Form.Group>
    //                     <input type="hidden" name="_csrf_token" value={token || ''}/>
    //                     <Button type="submit" className={"w-100"} variant="type-2" >Search</Button>
    //                     <Button type="button" className={"w-100"} variant="type-2" onClick={changeState}>Change state</Button>
    //                 </Form>
    //             </div>
    //         </div>
    //     )
    // }
}

function mapStateToProps(state) {
    return {
        userData: state.userData
    }
}

function matchDispatchToProps(dispatch) {
    return bindActionCreators({changeLoginStatus: changeLoginStatus}, dispatch)
}

export default connect(mapStateToProps, matchDispatchToProps)(Login);


