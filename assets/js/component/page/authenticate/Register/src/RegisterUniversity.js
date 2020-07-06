import React, {useEffect, useState} from 'react';
import {bindActionCreators} from 'redux';
import {push} from 'connected-react-router';
import {connect} from 'react-redux';
import {validateForm} from '../../../../src/FormValidation';
import {withRouter} from 'react-router-dom';
import {t} from '../../../../src/translate/translate';
import {createUniversityUser} from '../../../../src/axios/axios';
import {alert} from '../../../../src/Alert/Alert';

function index(props) {
  const [code, setCode] = useState('');
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');

  const handleSubmit = (e) => {
    e.preventDefault();
    if (!validateForm(props.lang, 'register-university')) {
      return;
    }

    let formData = new FormData();
    formData.set('code', code);
    formData.set('User[email]', email);
    formData.set('User[password]', password);
    createUniversityUser(props.lang, formData).then((res) => {
      if (res.status) redirect(`/register/confirm-email-send/${res.data}`);
      else alert('error', t(props.lang, res.error));
    });
  };

  const redirect = (url) => {
    props.push(url);
    props.history.push(url);
  };

  return (
    <form className={'register-university'} onSubmit={(e) => handleSubmit(e)} autoComplete="off" noValidate>
      <div className={`form-group`}>
        <div className={`form-group`}>
          <input
            name={'access_code_2'}
            className={`form-control input input-type-1 w-100`}
            placeholder={t(props.lang, 'Access code')}
            type="text"
            value={code}
            onChange={(e) => setCode(e.target.value)}
            autoComplete={'off'}
            required
          />
          <span className={'error'} />
        </div>
      </div>
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
      <button type="submit" className={'w-100 btn btn-type-2'}>
        {t(props.lang, 'Confirm')}
      </button>
    </form>
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
