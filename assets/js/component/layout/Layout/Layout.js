import React, {useEffect} from 'react';
import {BrowserRouter as Router, Switch, Route, withRouter} from 'react-router-dom';
import Header from '../Header/Header';
import Footer from '../Footer/Footer';
import Welcome from '../../page/welcome/Welcome/Welcome';
import Schedule from '../../page/schedule/Schedule/Schedule';
import Contact from '../../page/contact/Contact/Contact';
import Business from '../../page/contact/Business/Business';
import Technical from '../../page/contact/Technical/Technical';
import Search from '../../page/search/Search/Search';
import Login from '../../page/authenticate/Login/Login';
import Register from '../../page/authenticate/Register/Register';
import ConfirmEmailSend from '../../page/authenticate/ConfirmEmailSend/ConfirmEmailSend';
import ResetPasswordEmailSend from '../../page/authenticate/ResetPasswordEmailSend/ResetPasswordEmailSend';
import ResetPassword from '../../page/authenticate/ResetPassword/ResetPassword';
import Profile from '../../page/profile/Profile/Profile';
import TermOfUse from '../../page/rule/TermOfUse/TermOfUse';
import {connect} from 'react-redux';
import {bindActionCreators} from 'redux';
import {loadUserModel} from '../../../redux/actions/user';

import './style.scss';
import '../../../../css/font/Neucha/Neucha-Regular.ttf';

function index(props) {
  useEffect(() => {
    props.loadUserModel();
  }, []);

  return (
    <Router>
      <div className={'content container'}>
        <Header />
        <main>
          <Switch>
            <Route path="/contact/business" component={Business} />
            <Route path="/contact/technical" component={Technical} />
            <Route path="/welcome" component={Welcome} />
            <Route path="/search" component={Search} />
            <Route path="/schedule/:type/:id" render={() => <Schedule key={props.loc.key} />} />
            <Route path="/contact" component={Contact} />
            <Route path="/login" component={Login} />
            <Route path="/register/confirm-email-send/:code" component={ConfirmEmailSend} />
            <Route path="/register" component={Register} />
            <Route path="/reset-password/email-send" component={ResetPasswordEmailSend} />
            <Route path="/reset-password" component={ResetPassword} />
            <Route path="/profile" component={Profile} />
            <Route path="/term-of-use" component={TermOfUse} />
          </Switch>
        </main>
        <Footer />
      </div>
    </Router>
  );
}

function mapStateToProps(state) {
  return {
    loc: state.router.location,
  };
}

function matchDispatchToProps(dispatch) {
  return bindActionCreators({loadUserModel: loadUserModel}, dispatch);
}

export default withRouter(connect(mapStateToProps, matchDispatchToProps)(index));
