import React, {useEffect, useState} from 'react';
import {bindActionCreators} from 'redux';
import {push} from 'connected-react-router';
import {connect} from 'react-redux';
import {preloaderEnd, preloaderStart} from '../../../src/Preloader/Preloader';
import axios from 'axios';
import {alert, alertException} from '../../../src/Alert/Alert';
import {validateForm} from '../../../src/FormValidation';
import {userLogin} from '../../../../redux/actions/user';
import './style.scss';

function index(props) {
  const [token, setToken] = useState('');
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');

  const [btnIsDisabled, setBtnIsDisabled] = useState(true);

  useEffect(() => {
    axios
      .post(`/react/login/get-csrf-token`)
      .then((res) => {
        setToken(res.data);
        setBtnIsDisabled(false);
      })
      .catch((error) => {
        alertException(error.response.status);
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

    preloaderStart();
    axios
      .post(`/react/login/login`, formData)
      .then((res) => {
        console.log(res.data.status);
        if (res.data.status) {
          alert('success', res.data.reason);
          props.userLogin({
            data: {
              id: res.data.user.id,
              email: res.data.user.email,
              role: res.data.user.role,
            },
          });
          console.log(1);
          redirect('/profile');
        } else {
          alert('error', res.data.reason);
          //If email not confirm, send again
          if (res.data.reasonCode === 101) {
            redirect(`/register/confirm-email-send/${res.data.code}`);
          }
          preloaderEnd();
        }
      })
      .catch((error) => {
        alertException(error.response.status);
        preloaderEnd();
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
  return bindActionCreators({push: push, userLogin: userLogin}, dispatch);
}

export default connect(mapStateToProps, matchDispatchToProps)(index);
