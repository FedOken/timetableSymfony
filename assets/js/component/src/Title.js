import React from 'react';
import {connect} from 'react-redux';
import {isEmpty} from './Helper';

function Title(props) {
  const titles = {
    '/welcome': 'Schedule - Welcome',
    '/search': 'Schedule - Search',
    '/contact/business': 'Schedule - Contact business',
    '/contact/technical': 'Schedule - Contact technical',
    '/contact': 'Schedule - Contact',
    '/login': 'Schedule - Login',
    '/register': 'Schedule - Register',
    '/reset-password/email-send': 'Schedule - Email send',
    '/reset-password': 'Schedule - Reset password',
    '/profile': 'Schedule - Profile',
  };

  if (isEmpty(titles[props.pathname])) {
    document.title = 'Schedule';
  } else {
    document.title = titles[props.pathname];
  }

  return <div></div>;
}

function mapStateToProps(state) {
  return {
    pathname: state.router.location.pathname,
  };
}

export default connect(mapStateToProps)(Title);
