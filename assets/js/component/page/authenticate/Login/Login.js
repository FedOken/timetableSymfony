import React, {useEffect, useState} from 'react';
import {bindActionCreators} from 'redux';
import {push} from 'connected-react-router';
import {connect} from 'react-redux';
import {alert, alertException} from '../../../src/Alert/Alert';
import {validateForm} from '../../../src/FormValidation';
import {loadUserModel} from '../../../../redux/actions/user';
import {getUserCsrfToken, postUserLogin} from '../../../src/axios/axios';
import './style.scss';

function index(props) {
  const [token, setToken] = useState('');
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');

  const [btnIsDisabled, setBtnIsDisabled] = useState(true);

  useEffect(() => {
    getUserCsrfToken().then((res) => {
      setToken(res.data);
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
    if (!validateForm('login-form')) {
      return;
    }

    let formData = new FormData();
    formData.set('email', email);
    formData.set('password', password);
    formData.set('_csrf_token', token);

    postUserLogin({}, formData, true).then((res) => {
      if (res.status) {
        props.loadUserModel();
        redirect('/profile');
      } else {
        alert('error', res.error);
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
    <div className="login container">
      <div className="col-xs-12 col-sm-6 col-md-4 block-center">
        <div className={'block-login'}>
          <span className={'block-name'}>Вход</span>

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
                placeholder={'Пароль'}
                type="password"
                value={password}
                onChange={(e) => setPassword(e.target.value)}
                autoComplete={'new-password'}
                required
              />
              <span className={'error'} />
            </div>
            <button type="submit" className={'w-100 btn btn-type-2'} disabled={btnIsDisabled}>
              Войти
            </button>
          </form>
          <div className={'block-additional'}>
            <p>
              Все еще нет аккаунта? <span onClick={() => clickRegister()}>Создайте</span>
            </p>
            <p>
              Забыли пароль? <span onClick={() => clickResetPassword()}>Восстановите!</span>
            </p>
          </div>
        </div>
      </div>
    </div>
  );
}

function mapStateToProps(state) {
  return {
    user: state.user,
  };
}

function matchDispatchToProps(dispatch) {
  return bindActionCreators({push: push, loadUserModel: loadUserModel}, dispatch);
}

export default connect(mapStateToProps, matchDispatchToProps)(index);
