import React, {useEffect} from 'react';
import { Switch, Route } from 'react-router-dom'

import Home from "../HomeComponents/Home";
import Login from "../LoginComponent/Login";
import Welcome from "../../component/page/welcome/Welcome";
import GroupShow from "../GroupComponents/GroupShow";
import {bindActionCreators} from "redux";
import {changeLoginStatus} from "../../redux/actions/header";
import {changeUserData} from "../../redux/actions/user";
import {connect} from "react-redux";
import axios from "axios";

function Content(props) {

    //Ajax on load
    useEffect(() => {
        if (!props.user.isLogin) {
            axios.post(`/react/content/get-login-status`)
                .then(res => {
                    if (res.data.length) {
                        let userData = {
                            status: true,
                            data: JSON.parse(res.data)
                        };
                        props.changeLoginStatus();
                        props.changeUserData(userData);
                    }
                });
        }

    }, []);

    return (
        <main>
            <Switch>
                <Route exact path='/' component={Home}/>
                <Route path='/welcome' component={Welcome}/>
                <Route path='/login' component={Login}/>
                <Route path='/group/show' component={GroupShow}/>
            </Switch>
        </main>
    );
}


function mapStateToProps(state) {
    return {
        user: state.user
    }
}

function matchDispatchToProps(dispatch) {
    return bindActionCreators({changeUserData: changeUserData, changeLoginStatus: changeLoginStatus}, dispatch)
}

export default connect(mapStateToProps, matchDispatchToProps)(Content);