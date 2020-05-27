import React from 'react';
import {BrowserRouter as Router, Switch, Route, withRouter} from "react-router-dom";
import Header from './Header';
import Footer from "./Footer";
import Welcome from "../page/welcome/Welcome";
import Schedule from "../page/schedule/Schedule";
import Contact from "../page/contact/Contact";
import Business from "../page/contact/Business";
import Technical from "../page/contact/Technical";
import Search from "../page/search/Search";
import Login from "../page/authenticate/Login";
import Register from "../page/authenticate/Register";
import ConfirmEmailSend from "../page/authenticate/ConfirmEmailSend";
import ResetPasswordEmailSend from "../page/authenticate/ResetPasswordEmailSend";
import ResetPassword from "../page/authenticate/ResetPassword";
import Profile from "../page/profile/Profile";
import {connect} from "react-redux";


function index(props) {
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
                        <Route path='/register/confirm-email-send' component={ConfirmEmailSend}/>
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
    }
}

export default withRouter(connect(mapStateToProps)(index));
