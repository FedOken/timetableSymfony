import React, { useState } from 'react';
import Button from "react-bootstrap/Button";
import {bindActionCreators} from "redux";
import {push} from "connected-react-router";
import {connect} from "react-redux";

function index(props) {

    const redirect = (url) => {
        props.push(url);
        props.history.push(url);
    };

    return (
        <div className="reset-password container">
            <div className="col-xs-12 col-sm-6 col-md-4 block-center">
                <div className={'block-reset'}>
                    <form>
                        <input className={'form-control input input-type-1 w-100'} placeholder={'Email'} type="email"/>
                        <button type={"button"} className={"w-100 btn btn-type-2"} onClick={() => redirect('/reset-password/email-send')}>Восстановить</button>
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