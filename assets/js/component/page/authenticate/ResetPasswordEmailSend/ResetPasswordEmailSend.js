import React from 'react';
import {bindActionCreators} from 'redux';
import {push} from 'connected-react-router';
import {connect} from 'react-redux';
import './style.scss';
import {withRouter} from 'react-router';
import {t} from '../../../src/translate/translate';

function index(props) {
  const redirect = (url) => {
    props.push(url);
    props.history.push(url);
  };

  return (
    <div className="reset-password-email-send container">
      <p className={'title'}>{t(props.lang, 'Email with new password is sent to your email')}!</p>
      <div>
        <button type={'button'} className={'btn btn-type-1'} onClick={() => redirect('/search')}>
          {t(props.lang, 'To search')}
        </button>
        <button type={'button'} className={'btn btn-type-2'} onClick={() => redirect('/login')}>
          {t(props.lang, 'Back to log in page')}
        </button>
      </div>
    </div>
  );
}

const mapToProps = (state) => {
  return {
    lang: state.lang,
  };
};

const matchDispatch = (dispatch) => {
  return bindActionCreators({push: push}, dispatch);
};

export default withRouter(connect(mapToProps, matchDispatch)(index));
