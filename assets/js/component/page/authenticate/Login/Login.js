import React, {useEffect, useState} from 'react';
import {bindActionCreators} from 'redux';
import {push} from 'connected-react-router';
import {connect} from 'react-redux';
import {alert, alertException} from '../../../src/Alert/Alert';
import {validateForm} from '../../../src/FormValidation';
import {loadUserModel} from '../../../../redux/actions/user';
import {getUserCsrfToken, postUserLogin} from '../../../src/axios/axios';
import './style.scss';
import {t} from '../../../src/translate/translate';

function index(props) {
  const [token, setToken] = useState('');
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');

  const [btnIsDisabled, setBtnIsDisabled] = useState(true);

  useEffect(() => {
    getUserCsrfToken(props.lang).then((res) => {
      setToken(res);
      setBtnIsDisabled(false);
    });
  }, []);

  const clickRegister = () => {
    redirect('/register');
  };

  const clickResetPassword = () => {
    redirect('/reset-password');
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    if (!validateForm(props.lang, 'login-form')) {
      return;
    }

    let formData = new FormData();
    formData.set('email', email);
    formData.set('password', password);
    formData.set('_csrf_token', token);

    postUserLogin(props.lang, {}, formData, true).then((res) => {
      if (res.status) {
        props.loadUserModel();
        redirect('/profile');
      } else {
        alert('error', t(props.lang, res.error));
        if (res.errorCode === 101) {
          redirect(`/register/confirm-email-send/${res.code}`);
        }
      }
    });
  };

  const redirect = (url) => {
    props.push(url);
    props.history.push(url);
  };

  return (
    <div className="login row h-100">
      <div className="col-12 col-md-6 col-lg-5 col-xl-4">
        <div className={'block-login'}>
          <span className={'block-name'}>{t(props.lang, 'Entry')}</span>

          <form className={'login-form'} onSubmit={(e) => handleSubmit(e)} autoComplete="off" noValidate>
            <div className={`form-group`}>
              <input
                name={'email'}
                className={`form-control input input-type-1 w-100`}
                placeholder={'Email'}
                type="email"
                value={email}
                onChange={(e) => setEmail(e.target.value)}
                autoComplete={'off'}
                required
              />
              <span className={'error'} />
            </div>

            <div className={`form-group`}>
              <input
                className={'form-control input input-type-1 w-100'}
                placeholder={t(props.lang, 'Password')}
                type="password"
                value={password}
                onChange={(e) => setPassword(e.target.value)}
                autoComplete={'new-password'}
                required
              />
              <span className={'error'} />
            </div>
            <button type="submit" className={'w-100 btn btn-type-2'} disabled={btnIsDisabled}>
              {t(props.lang, 'Log in')}
            </button>
          </form>
          <div className={'block-additional'}>
            <p>
              {t(props.lang, 'Still no account')}?{' '}
              <span onClick={() => clickRegister()}>{t(props.lang, 'Create')}!</span>
            </p>
            <p>
              {t(props.lang, 'Forgot your password')}?{' '}
              <span onClick={() => clickResetPassword()}>{t(props.lang, 'Restore1')}!</span>
            </p>
          </div>
        </div>
      </div>
    </div>
  );
}

const mapToProps = (state) => {
  return {
    user: state.user,
    lang: state.lang,
  };
};

const matchDispatch = (dispatch) => {
  return bindActionCreators({push: push, loadUserModel: loadUserModel}, dispatch);
};

export default connect(mapToProps, matchDispatch)(index);
