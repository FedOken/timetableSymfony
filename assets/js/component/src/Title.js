import React from 'react';
import {connect} from 'react-redux';
import {isEmpty} from './Helper';
import {t} from './translate/translate';

function Title(props) {
  const titles = {
    '/': 'Schedule - ' + t(props.lang, 'Home'),
    '/search': 'Schedule - ' + t(props.lang, 'Search'),
    '/contact/business': 'Schedule - ' + t(props.lang, 'Business matters'),
    '/contact/technical': 'Schedule - ' + t(props.lang, 'Technical issue'),
    '/contact': 'Schedule - ' + t(props.lang, 'Contact'),
    '/login': 'Schedule - ' + t(props.lang, 'Log in'),
    '/register': 'Schedule - ' + t(props.lang, 'Registration'),
    '/reset-password/email-send': 'Schedule - ' + t(props.lang, 'Email send'),
    '/reset-password': 'Schedule - ' + t(props.lang, 'Reset password'),
    '/profile': 'Schedule - ' + t(props.lang, 'Profile'),
    '/term-of-use': 'Schedule - ' + t(props.lang, 'Term of Use'),
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
    lang: state.lang,
    pathname: state.router.location.pathname,
  };
}

export default connect(mapStateToProps)(Title);
