import React, {useEffect} from 'react';
import { Switch, Route } from 'react-router-dom'

import Home from "../HomeComponents/Home";
import Login from "../LoginComponent/Login";
import GroupShow from "../GroupComponents/GroupShow";
import {bindActionCreators} from "redux";
import {changeActiveElement} from "../../redux/actions/header";
import {changeUserData} from "../../redux/actions/user";
import {connect} from "react-redux";
import axios from "axios";

function Content(props) {

    const clickRoute = () => {

        console.log('asdasd');
    };

    //Ajax on load
    useEffect(() => {
        axios.post(`/react/content/get-login-status`)
            .then(res => {
                if (res.data) {
                    let userData = {
                        status: true,
                        data: res.data
                    };
                    console.log('ajax');
                    props.changeUserData(userData);
                }
            });

    }, []);

    return (
        <main>
            <Switch>
                <Route exact path='/' component={Home} onClick={clickRoute}/>
                <Route path='/login' component={Login}/>
                <Route path='/group/show' component={GroupShow}/>
            </Switch>
        </main>
    );
}


function mapStateToProps(state) {
    return {
        //userData: state.userData
    }
}

function matchDispatchToProps(dispatch) {
    return bindActionCreators({changeUserData: changeUserData}, dispatch)
}

export default connect(mapStateToProps, matchDispatchToProps)(Content);