import React, {useState} from 'react';
import {bindActionCreators} from 'redux';
import {push} from 'connected-react-router';
import {connect} from 'react-redux';
import {validateForm} from '../../../src/FormValidation';
import {alert} from '../../../src/Alert/Alert';
import './style.scss';
import {withRouter} from 'react-router';
import {t} from '../../../src/translate/translate';
import {userResetPassword} from '../../../src/axios/axios';

function index(props) {
  const [email, setEmail] = useState('');

  const handleSubmit = (e) => {
    e.preventDefault();
    if (!validateForm(props.lang, 'reset-password-form')) {
      return;
    }

    let formData = new FormData();
    formData.set('email', email);
    formData.set('lang', props.lang);

    userResetPassword(props.lang, formData).then((res) => {
      if (!res.status) alert('error', t(props.lang, res.error));
      else redirect(`/reset-password/email-send`);
    });
  };

  const redirect = (url) => {
    props.push(url);
    props.history.push(url);
  };

  return (
    <div className="reset-password row h-100">
      <div className="col-12 col-md-6 col-lg-5 col-xl-4">
        <div className={'block-reset'}>
          <span className={'block-name'}>{t(props.lang, 'Restore2')}</span>
          <form className={'reset-password-form'} onSubmit={(e) => handleSubmit(e)} noValidate>
            <div className={`form-group`}>
              <input
                className={'form-control input input-type-1 w-100'}
                placeholder={'Email'}
                type="email"
                value={email}
                onChange={(e) => setEmail(e.target.value)}
                required
              />
              <span className={'error'} />
            </div>
            <button type={'submit'} className={'w-100 btn btn-type-2'}>
              {t(props.lang, 'Confirm')}
            </button>
          </form>
        </div>
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
