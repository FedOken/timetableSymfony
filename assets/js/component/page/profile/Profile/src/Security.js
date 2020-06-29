import React, {useState} from 'react';
import {validateForm} from '../../../../src/FormValidation';
import {preloaderEnd, preloaderStart} from '../../../../src/Preloader/Preloader';
import axios from 'axios';
import {alert, alertException} from '../../../../src/Alert/Alert';
import {bindActionCreators} from 'redux';
import {loadUserRelation} from '../../../../../redux/actions/user';
import {withRouter} from 'react-router';
import {connect} from 'react-redux';
import {t} from '../../../../src/translate/translate';

function index(props) {
  const [password, setPassword] = useState('');
  const [repPassword, setRepPassword] = useState('');

  const handleSubmit = (e) => {
    e.preventDefault();
    if (!validateForm(props.lang, 'profile-security')) return;

    let formData = new FormData();
    formData.set('password', password);
    formData.set('repeatPassword', repPassword);

    preloaderStart();
    axios
      .post(`/api/user/update-password`, formData)
      .then((res) => {
        if (res.data.status) {
          alert('success', t(props.lang, 'Password successfully updated.'));
        } else {
          alert('error', t(props.lang, res.data.error));
        }
      })
      .catch((error) => {
        alertException(error.response.status);
      })
      .then(() => {
        preloaderEnd();
      });
  };

  return (
    <form className={'profile-security'} onSubmit={(e) => handleSubmit(e)} autoComplete="off" noValidate>
      <div className={'block'}>
        <p className={'block-title'}>{t(props.lang, 'Change password')}</p>
        <div className={`form-group`}>
          <input
            className={`form-control input input-type-1 w-100`}
            placeholder={t(props.lang, 'Password')}
            type="password"
            value={password}
            onChange={(e) => setPassword(e.target.value)}
            autoComplete={'new-password'}
            min={5}
            required
          />
          <span className={'error'} />
        </div>
        <div className={`form-group`}>
          <input
            className={`form-control input input-type-1 w-100`}
            placeholder={t(props.lang, 'Repeat password')}
            type="password"
            value={repPassword}
            onChange={(e) => setRepPassword(e.target.value)}
            autoComplete={'new-password'}
            required
          />
          <span className={'error'} />
        </div>
      </div>
      <div className={'buttons'}>
        <button type="submit" className={'btn btn-type-2'}>
          {t(props.lang, 'Save')}
        </button>
      </div>
    </form>
  );
}

const mapToProps = (state) => {
  return {
    lang: state.lang,
  };
};

export default withRouter(connect(mapToProps)(index));
