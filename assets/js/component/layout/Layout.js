import React, {useEffect} from 'react';
import {BrowserRouter as Router, Switch, Route, withRouter} from "react-router-dom";
import Header from './Header';
import Footer from "./Footer";
import Welcome from "../page/welcome/Welcome/Welcome";
import Schedule from "../page/schedule/Schedule/Schedule";
import Contact from "../page/contact/Contact/Contact";
import Business from "../page/contact/Business/Business";
import Technical from "../page/contact/Technical/Technical";
import Search from "../page/search/Search";
import Login from "../page/authenticate/Login/Login";
import Register from "../page/authenticate/Register/Register";
import ConfirmEmailSend from "../page/authenticate/ConfirmEmailSend/ConfirmEmailSend";
import ResetPasswordEmailSend from "../page/authenticate/ResetPasswordEmailSend/ResetPasswordEmailSend";
import ResetPassword from "../page/authenticate/ResetPassword/ResetPassword";
import Profile from "../page/profile/Profile";
import {connect} from "react-redux";
import {preloaderEnd, preloaderStart} from "../src/Preloader/Preloader";
import axios from "axios";
import {alertException} from "../src/Alert/Alert";
import {bindActionCreators} from "redux";
import {changeUserData} from "../../redux/actions/user";
import {isEmpty} from '../src/Helper'

import '../../../css/font/Neucha/Neucha-Regular.ttf'


function index(props) {

    useEffect(() => {
        preloaderStart();
        axios.post(`/react/layout/get-user`)
            .then((res) => {
                if (!isEmpty(res.data)) {
                    props.changeUserData({
                        status: true,
                        id: res.data.id,
                        email: res.data.email,
                        role: res.data.role,
                    });
                }
            })
            .catch((error) => {alertException(error.response.status)})
            .then(() => { preloaderEnd() });
    }, []);

    return (
        <Router>
            <div className={'content'}>
                <Header/>
                <main>
                    <Switch>
                        <Route path='/contact/business' component={Business}/>
                        <Route path='/contact/technical' component={Technical}/>
                        <Route path='/welcome' component={Welcome}/>
                        <Route path='/search' component={Search}/>
                        <Route path='/schedule/:type/:id' render={() => (<Schedule key={props.loc.key}/>) } />
                        <Route path='/contact' component={Contact}/>
                        <Route path='/login' component={Login}/>
                        <Route path='/register/confirm-email-send/:code' component={ConfirmEmailSend}/>
                        <Route path='/register' component={Register}/>
                        <Route path='/reset-password/email-send' component={ResetPasswordEmailSend}/>
                        <Route path='/reset-password' component={ResetPassword}/>
                        <Route path='/profile' component={Profile}/>
                    </Switch>
                </main>
                <Footer/>
            </div>
        </Router>
    );
}

function mapStateToProps(state) {
    return {
        loc: state.router.location,
        user: state.user
    }
}

function matchDispatchToProps(dispatch) {
    return bindActionCreators({changeUserData: changeUserData}, dispatch)
}

export default withRouter(connect(mapStateToProps, matchDispatchToProps)(index));
